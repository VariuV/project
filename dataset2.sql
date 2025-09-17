CREATE DATABASE QuanLyDoan;
USE QuanLyDoan;
-- 1. To chuc & Nguoi dung
CREATE TABLE ToChuc (
    ToChucID INT AUTO_INCREMENT PRIMARY KEY,
    TenToChuc VARCHAR(255) NOT NULL,
    CapDo ENUM('Truong','Khoa','ChiDoan') NOT NULL,
    ToChucChaID INT,
    FOREIGN KEY (ToChucChaID) REFERENCES ToChuc(ToChucID)
);

CREATE TABLE NguoiDung (
    NguoiDungID INT AUTO_INCREMENT PRIMARY KEY,
    HoTen VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE,
    VaiTro ENUM('CanBoTruong','CanBoKhoa','CanBoChiDoan','DoanVien') NOT NULL,
    ToChucID INT NOT NULL,
    FOREIGN KEY (ToChucID) REFERENCES ToChuc(ToChucID)
);

-- 2. Ke hoach nam hoc & Tieu chi
CREATE TABLE KeHoachNamHoc (
    KeHoachID INT AUTO_INCREMENT PRIMARY KEY,
    NamHoc VARCHAR(20) NOT NULL,
    NguoiTaoID INT,
    NgayTao DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (NguoiTaoID) REFERENCES NguoiDung(NguoiDungID)
);

CREATE TABLE TieuChi (
    TieuChiID INT AUTO_INCREMENT PRIMARY KEY,
    MoTa TEXT NOT NULL,
    GiaTriMucTieu VARCHAR(100),
    KeHoachID INT,
    FOREIGN KEY (KeHoachID) REFERENCES KeHoachNamHoc(KeHoachID)
);

CREATE TABLE HoatDongKeHoach (
    HoatDongKHID INT AUTO_INCREMENT PRIMARY KEY,
    TenHoatDong VARCHAR(255) NOT NULL,
    Thang INT,
    HocKy ENUM('HK1','HK2'),
    TieuChiID INT,
    KeHoachID INT,
    FOREIGN KEY (TieuChiID) REFERENCES TieuChi(TieuChiID),
    FOREIGN KEY (KeHoachID) REFERENCES KeHoachNamHoc(KeHoachID)
);
-- 3. Hoat dong
CREATE TABLE HoatDong (
    HoatDongID INT AUTO_INCREMENT PRIMARY KEY,
    TenHoatDong VARCHAR(255) NOT NULL,
    LoaiHoatDong ENUM('TheoKeHoach','NgoaiKeHoach') NOT NULL,
    MucTieu TEXT,
    TieuChiID INT,
    NguoiTaoID INT,
    ToChucID INT,
    TrangThai ENUM('ChoDuyet','DaDuyet','TuChoi','HoanThanh') DEFAULT 'ChoDuyet',
    FOREIGN KEY (TieuChiID) REFERENCES TieuChi(TieuChiID),
    FOREIGN KEY (NguoiTaoID) REFERENCES NguoiDung(NguoiDungID),
    FOREIGN KEY (ToChucID) REFERENCES ToChuc(ToChucID)
);

CREATE TABLE DiemDanh (
    HoatDongID INT,
    NguoiDungID INT,
    TrangThaiThamGia ENUM('CoMat','Vang') DEFAULT 'CoMat',
    PRIMARY KEY (HoatDongID, NguoiDungID),
    FOREIGN KEY (HoatDongID) REFERENCES HoatDong(HoatDongID),
    FOREIGN KEY (NguoiDungID) REFERENCES NguoiDung(NguoiDungID)
);

CREATE TABLE BaoCaoHoatDong (
    BaoCaoID INT AUTO_INCREMENT PRIMARY KEY,
    HoatDongID INT,
    TomTat TEXT,
    HinhAnh TEXT,
    ChiPhi DECIMAL(12,2),
    NguoiDuyetID INT,
    TrangThai ENUM('ChoDuyet','DaDuyet','TuChoi') DEFAULT 'ChoDuyet',
    FOREIGN KEY (HoatDongID) REFERENCES HoatDong(HoatDongID),
    FOREIGN KEY (NguoiDuyetID) REFERENCES NguoiDung(NguoiDungID)
);

CREATE TABLE MinhChung (
    MinhChungID INT AUTO_INCREMENT PRIMARY KEY,
    HoatDongID INT,
    NguoiNopID INT,
    FileURL VARCHAR(500),
    NguoiDuyetID INT,
    TrangThai ENUM('ChoDuyet','DaDuyet','TuChoi') DEFAULT 'ChoDuyet',
    FOREIGN KEY (HoatDongID) REFERENCES HoatDong(HoatDongID),
    FOREIGN KEY (NguoiNopID) REFERENCES NguoiDung(NguoiDungID),
    FOREIGN KEY (NguoiDuyetID) REFERENCES NguoiDung(NguoiDungID)
);
-- 4. Danh gia & thong ke
CREATE TABLE DanhGia (
    DanhGiaID INT AUTO_INCREMENT PRIMARY KEY,
    ToChucID INT,
    NamHoc VARCHAR(20),
    TongDiem DECIMAL(5,2),
    XepLoai ENUM('XuatSac','Kha','TrungBinh','Yeu'),
    NguoiDuyetID INT,
    FOREIGN KEY (ToChucID) REFERENCES ToChuc(ToChucID),
    FOREIGN KEY (NguoiDuyetID) REFERENCES NguoiDung(NguoiDungID)
);

CREATE TABLE DiemTieuChi (
    DanhGiaID INT,
    TieuChiID INT,
    Diem DECIMAL(5,2),
    PRIMARY KEY (DanhGiaID, TieuChiID),
    FOREIGN KEY (DanhGiaID) REFERENCES DanhGia(DanhGiaID),
    FOREIGN KEY (TieuChiID) REFERENCES TieuChi(TieuChiID)
);
