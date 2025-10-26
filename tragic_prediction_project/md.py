import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error, r2_score
from sklearn.preprocessing import StandardScaler
from sklearn.impute import SimpleImputer
from sklearn.pipeline import Pipeline

#Doc du lieu
path = "G:/quan/machine/data/train_clean.csv"
df = pd.read_csv(path)

# print(f"so dong, so cot: {df.shape}")
# print("cot co san:", df.columns.tolist())

#lm sach LOS
df["LOS"] = pd.to_numeric(df["LOS"], errors="coerce")
df["LOS"] = df["LOS"].fillna(df["LOS"].mean())

# sua categorical 
categorical_cols = ["period", "street_name", "street_type"]
for col in categorical_cols:
    if col in df.columns:
        df[col] = df[col].fillna("unknown").astype(str)
        df[col], _ = pd.factorize(df[col])

# chon feature va label
feature_cols = [col for col in df.columns if col not in ["LOS", "date"]]
X = df[feature_cols].copy()
y = df["LOS"]

# print("X shape:", X.shape)
# print("y shape:", y.shape)

# ktr NaN
# print(" NaN trong X:", X.isna().sum().sum())
# print(" NaN trong y:", y.isna().sum())

# Impute numeric NaN va tb
numeric_cols = X.select_dtypes(include=[np.number]).columns.tolist()
imputer = SimpleImputer(strategy="mean")
X[numeric_cols] = imputer.fit_transform(X[numeric_cols])

# Chia du lieu train/test
# X_train, X_test, y_train, y_test = train_test_split(
#     X, y, test_size=0.2, random_state=42
# )
X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.3, random_state=42)
X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=(1/3), random_state=42)
#Chuan hoa du lieu
scaler = StandardScaler()

X_train[numeric_cols] = scaler.fit_transform(X_train[numeric_cols])
X_test[numeric_cols] = scaler.transform(X_test[numeric_cols])
X_val[numeric_cols] = scaler.transform(X_val[numeric_cols])
#xdung mo hinh
model = LinearRegression()
# train mo hinh
model.fit(X_train, y_train)

#predict
y_val_pred = model.predict(X_val)


#Danh gia mo hinh
val_mse = mean_squared_error(y_val, y_val_pred)
val_r2 = r2_score(y_val, y_val_pred)
print(f"val - MSE: {val_mse:.4f}, R2: {val_r2:.4f}")
y_test_pred = model.predict(X_test)
test_mse = mean_squared_error(y_test, y_test_pred)
test_r2 = r2_score(y_test, y_test_pred)
print(f"Test - MSE: {test_mse:.4f}, R2: {test_r2:.4f}")
#hien thi 
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



# Luu kq
result_df.to_csv("baseline_results.csv", index=False, encoding="utf-8-sig")
#save mo hinh
import joblib
joblib.dump(model, "traffic_model_baseline.pkl")
joblib.dump(scaler, "traffic_scaler.pkl")

