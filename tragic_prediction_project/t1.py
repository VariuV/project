# Doc cac thu vien can thiet
import pandas as pd
import numpy as np
from difflib import get_close_matches
from sklearn.model_selection import train_test_split

# Ham lam sach du lieu so, loai gia tri am 
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

# Ham lam sach bang traffic chung
def sua_lam_sach_traffic(df):
    df = df.copy()

    # Xu ly cot thoi gian neu ton tai
    for col in ["timestamp", "time", "datetime", "date"]:
        if col in df.columns:
            df[col] = pd.to_datetime(df[col], errors="coerce")
            break
    # Tu dong nhan dien va lam sach cac cot so
    for col in df.columns:
        if df[col].dtype == object:
            temp = pd.to_numeric(df[col], errors="coerce")
            if temp.notna().mean() > 0.5:
                df[col] = clean_numeric_series(df[col])
        elif np.issubdtype(df[col].dtype, np.number):
            df[col] = clean_numeric_series(df[col])
    return df



# Ham chinh
def main():
    # Duong dan den thu muc du lieu
    path = "G:/quan/machine/data/"
    
    # Doc cac file csv
    df_nodes = pd.read_csv(path + "nodes.csv")
    df_segment_status = pd.read_csv(path + "segment_status.csv")
    df_segments = pd.read_csv(path + "segments.csv")
    df_streets = pd.read_csv(path + "streets.csv")
    df_train = pd.read_csv(path + "train.csv")

    # Lam sach file train
    df_train_clean = sua_lam_sach_traffic(df_train)

    # --- LOS ---
    if "LOS" not in df_train.columns:
        raise ValueError(" LOS không ton tai trong train.csv!")
    
    if df_train["LOS"].dtype == object:
        mapping = {"A":1, "B":2, "C":3, "D":4, "E":5, "F":6}
        df_train["LOS"] = df_train["LOS"].map(mapping)
    
    df_train["LOS"] = df_train["LOS"].fillna(df_train["LOS"].mean())

    # --- Encode categorical ---
    categorical_cols = ["period", "street_name", "street_type"]
    for col in categorical_cols:
        if col in df_train.columns:
            df_train[col] = df_train[col].astype(str).replace("nan", "unknown")
            df_train[col], uniques = pd.factorize(df_train[col])
            print(f"{col} factorized,  unique: {len(uniques)}")
    # Chuan hoa cac cot thoi gian
    df_segment_status["updated_at"] = pd.to_datetime(df_segment_status["updated_at"], errors="coerce")
    df_segments["created_at"] = pd.to_datetime(df_segments["created_at"], errors="coerce")
    df_segments["updated_at"] = pd.to_datetime(df_segments["updated_at"], errors="coerce")
    df_train["date"] = pd.to_datetime(df_train["date"], errors="coerce")

    # Lam sach segment_status
    df_segment_status = df_segment_status.drop_duplicates(subset=["updated_at", "segment_id"])
    df_segment_status = df_segment_status.sort_values("updated_at")
    df_segment_status["velocity"] = clean_numeric_series(
        df_segment_status["velocity"],
        interpolate_time=True,
        timestamps=df_segment_status["updated_at"]
    )

    # Lam sach train
    df_train = df_train.drop_duplicates(subset=["date", "segment_id", "period"])
    df_train = df_train.sort_values(["date", "period"])

    # # Lam sach segments
    # df_segments = df_segments.ffill().bfill()

    # # Lam sach streets
    # df_streets = df_streets.ffill().bfill()

    # # Lam sach nodes
    # df_nodes = df_nodes.ffill().bfill()

    # # Cai dat hien thi bang day du cot
    # pd.set_option('display.max_columns', None)
    # pd.set_option('display.width', 200)

    # # Ham hien thi ket qua truoc va sau khi lam sach
    # def show_clean_result(name,  cleaned_df):
    #     print(f"\n====================== {name.upper()} ======================")
    #     # print(f"--- Bang goc ({name}) ---")
    #     # print(original_df.head())
    #     print(f"\n--- Bang sau khi lam sach ({name}_clean) ---")
    #     print(cleaned_df.head())

    # # Hien thi ket qua 5 bang
    # # df_nodes_raw = pd.read_csv(path + "nodes.csv")
    # show_clean_result("nodes", df_nodes)

    # # df_segment_status_raw = pd.read_csv(path + "segment_status.csv")
    # show_clean_result("segment_status", df_segment_status)

    # # df_segments_raw = pd.read_csv(path + "segments.csv")
    # show_clean_result("segments", df_segments)

    # # df_streets_raw = pd.read_csv(path + "streets.csv")
    # show_clean_result("streets", df_streets)

    # # df_train_raw = pd.read_csv(path + "train.csv")
    # show_clean_result("train", df_train)


# # b Luu lai cac bang da lam sach ra file CSV moi
#     df_nodes.to_csv(path + "nodes_clean.csv", index=False, encoding="utf-8-sig")
#     df_segment_status.to_csv(path + "segment_status_clean.csv", index=False, encoding="utf-8-sig")
#     df_segments.to_csv(path + "segments_clean.csv", index=False, encoding="utf-8-sig")
#     df_streets.to_csv(path + "streets_clean.csv", index=False, encoding="utf-8-sig")
    df_train.to_csv(path + "train_clean.csv", index=False, encoding="utf-8-sig")

    
    df_train = pd.read_csv(path + "train.csv")

    # Lam sach du lieu
    df_train = sua_lam_sach_traffic(df_train)

    #Chia du lieu
    # Gia su bien LOS la bien muc tieu (label)
    # feature_cols = [col for col in df_train.columns if col not in ["LOS", "date"]]
    # X = df_train[feature_cols]
    # y = df_train["LOS"]

    # # Chia 70% train - 20% test - 10% validation
    # X_train, X_temp, y_train, y_temp = train_test_split(X, y, test_size=0.3, random_state=42)
    # X_val, X_test, y_val, y_test = train_test_split(X_temp, y_temp, test_size=(2/3), random_state=42)

    # print("\n================ CHIA DU LIEU ================")
    # print("Kich thuoc tap train:", X_train.shape, y_train.shape)
    # print("Kich thuoc tap validation:", X_val.shape, y_val.shape)
    # print("Kich thuoc tap test:", X_test.shape, y_test.shape)
    # print("==============================================")

    # # Luu cac tap du lieu thanh file CSV de dung lai sau nay
    # X_train.to_csv("X_train_clean.csv", index=False, encoding="utf-8-sig")
    # y_train.to_csv("y_train_clean.csv", index=False, encoding="utf-8-sig")
    # X_val.to_csv("X_val_clean.csv", index=False, encoding="utf-8-sig")
    # y_val.to_csv("y_val_clean.csv", index=False, encoding="utf-8-sig")
    # X_test.to_csv("X_test_clean.csv", index=False, encoding="utf-8-sig")
    # y_test.to_csv("y_test_clean.csv", index=False, encoding="utf-8-sig")

# Chay chuong trinh chinh
if __name__ == "__main__":
    main()
