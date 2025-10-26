import pandas as pd
import numpy as np
import xgboost as xgb
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.metrics import accuracy_score, classification_report


path = "G:/quan/machine/data/train_clean.csv"
df = pd.read_csv(path)

# sua kieu LOS
if df["LOS"].dtype == object:
    mapping = {"A":0, "B":1, "C":2, "D":3, "E":4, "F":5}  # 0-based mapping
    df["LOS"] = df["LOS"].map(mapping)

# xoa NaN  trong LOS
df = df.dropna(subset=["LOS"])
df["LOS"] = df["LOS"].astype(int)

#Encode cot co gia tri dac biet
categorical_cols = ["period", "street_name", "street_type"]
for col in categorical_cols:
    if col in df.columns:
        df[col] = df[col].astype(str).replace("nan", "unknown")
        df[col], uniques = pd.factorize(df[col])
       
#Feature va label 
feature_cols = [col for col in df.columns if col not in ["LOS", "date"]]
X = df[feature_cols]
y = df["LOS"]

#xoa NaN trong X 
X = X.fillna(0)

#Chia du lieu
X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.3, random_state=42)
X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=(1/3), random_state=42)

#Chuan hoa du lieu
numeric_cols = X.select_dtypes(include=['number']).columns.tolist()
scaler = StandardScaler()
X_train[numeric_cols] = scaler.fit_transform(X_train[numeric_cols])
X_val[numeric_cols] = scaler.transform(X_val[numeric_cols])
X_test[numeric_cols] = scaler.transform(X_test[numeric_cols])


# ktr la so trong khoang
classes, y_train_encoded = np.unique(y_train, return_inverse=True)
y_val_encoded = np.searchsorted(classes, y_val)
y_test_encoded = np.searchsorted(classes, y_test)
num_classes = len(classes)

# tao DMatrix 
dtrain = xgb.DMatrix(X_train, label=y_train_encoded)
dval = xgb.DMatrix(X_val, label=y_val_encoded)
dtest = xgb.DMatrix(X_test, label=y_test_encoded)

# xdung XGBoost
params = {
    "objective": "multi:softmax",
    "num_class": num_classes,  
    "eval_metric": "mlogloss",
    "eta": 0.1,
    "max_depth": 5,
    "seed": 42
}

# ap dung early stopping
evals = [(dtrain, "train"), (dval, "validation")]
model = xgb.train(
    params, 
    dtrain, 
    num_boost_round=500, 
    evals=evals,
    early_stopping_rounds=20, 
    verbose_eval=False
)
y_train_pred = model.predict(dtrain)
y_val_pred = model.predict(dval)
y_test_pred = model.predict(dtest)
result_df = pd.DataFrame({
    "LOS": y_test.values[:10],
    "LOS_val": y_val_pred[:10] ,
    "LOS_test": y_test_pred[:10]
})
print("\n So sanh:")
pd.set_option('display.max_rows', None)   
pd.set_option('display.max_columns', None) 
pd.set_option('display.width', None)       
pd.set_option('display.max_colwidth', None)
print(result_df)
#predict
y_pred = model.predict(dtest)

# print("\nAccuracy:", accuracy_score(y_test_encoded, y_pred))
# print("\n:\n", classification_report(y_test_encoded, y_pred))
# Luu kq
result_df.to_csv("XGBoost_results.csv", index=False, encoding="utf-8-sig")
#save mo hinh
import joblib
joblib.dump(model, "traffic_model_XGBoost.pkl")
joblib.dump(scaler, "traffic_scaler_2.pkl")