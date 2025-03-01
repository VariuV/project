const nutdrop = document.querySelector('.bxs-down-arrow');
const bangdrop = document.querySelector('.thongtin');
const hientt = document.querySelector('.xemtt');
const thongtin = document.querySelector('.ca-nhan');
nutdrop.addEventListener('click', (e)=>{
    e.preventDefault();
    
    if(bangdrop.classList.contains('active')){
        bangdrop.classList.remove('active');
    }else{
        bangdrop.classList.add('active');
    };
    thongtin.classList.remove('active');
});
hientt.addEventListener('click', (e)=>{
    e.preventDefault();

    if(thongtin.classList.contains('active')){
        thongtin.classList.remove('active');
    }else{
        thongtin.classList.add('active');
    };
});
let tenTk = localStorage.getItem('taiKhoan');
let tenEmail = localStorage.getItem('email');
let tenNgay = localStorage.getItem('date'); 

document.getElementById("myTk").textContent = tenTk;

document.getElementById("myTk1").textContent = tenTk;

document.getElementById("myEmail").textContent = tenEmail;

document.getElementById("createDate").textContent = tenNgay;

document.getElementById("loiChao").textContent = `Chào mừng ${tenTk}!`;