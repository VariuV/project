
import pandas as pd
import numpy as np
from difflib import get_close_matches
from sklearn.model_selection import train_test_split



def clean_numeric_series(series, interpolate_time=False, timestamps=None):
    series = pd.to_numeric(series, errors="coerce")
    series = series.where(series >= 0, np.nan)
    if interpolate_time and timestamps is not None:
        try:
            ts = pd.to_datetime(timestamps, errors="coerce")
            series = series.interpolate(method="time", limit_direction="both", axis=0)
        except Exception as e:
            print("Interpolation failed:", e)
    return series


def sua_lam_sach_traffic(df):
    df = df.copy()

    for col in ["timestamp", "time", "datetime", "date"]:
        if col in df.columns:
            df[col] = pd.to_datetime(df[col], errors="coerce")
            break

    for col in df.columns:
        if df[col].dtype == object:
            temp = pd.to_numeric(df[col], errors="coerce")
            if temp.notna().mean() > 0.5:
                df[col] = clean_numeric_series(df[col])
        elif np.issubdtype(df[col].dtype, np.number):
            df[col] = clean_numeric_series(df[col])
    return df


def main():
    path = "G:/quan/machine/data/"
    

    df_train = pd.read_csv(path + "train.csv")
    

    df_train = sua_lam_sach_traffic(df_train)
    
 
    if "LOS" not in df_train.columns:
        raise ValueError("LOS k ton tai train.csv!")
    
    if df_train["LOS"].dtype == object:
        mapping = {"A":1, "B":2, "C":3, "D":4, "E":5, "F":6}
        df_train["LOS"] = df_train["LOS"].map(mapping)
    
    df_train["LOS"] = df_train["LOS"].fillna(df_train["LOS"].mean())

    
    categorical_cols = ["period", "street_name", "street_type"]
    for col in categorical_cols:
        if col in df_train.columns:
            df_train[col] = df_train[col].astype(str).replace("nan", "unknown")
            df_train[col], uniques = pd.factorize(df_train[col])
            print(f"{col} factorized, unique: {len(uniques)}")


    df_train.to_csv(path + "train_clean.csv", index=False, encoding="utf-8-sig")
   

    
    feature_cols = [col for col in df_train.columns if col not in ["LOS", "date"]]
    X = df_train[feature_cols]
    y = df_train["LOS"]

    X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.3, random_state=42)
    X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=(2/3), random_state=42)

    

if __name__ == "__main__":
    main()
