const login = document.querySelector('.login');
const loginlink = document.querySelector('.login-link');
const reglink = document.querySelector('.register-link');
const dangnhap = document.querySelector('.nutlogin');
const iconclose = document.querySelector('.nuttat');
const dangnhap1 = document.querySelector('.loginnew');

const yeucau = document.getElementById("yeucausignin");

reglink.addEventListener('click',   (e)=>{
    e.preventDefault();
    login.classList.add('active');
});

loginlink.addEventListener('click', (e)=>{
    e.preventDefault();
    login.classList.remove('active');
});

yeucau.addEventListener('click',   (e)=>{
    e.preventDefault();
    login.classList.add('active-mo');
});

dangnhap.addEventListener('click', (e)=>{
    e.preventDefault();
    login.classList.add('active-mo');
});



dangnhap1.addEventListener('click', (e)=>{
    e.preventDefault();
    login.classList.add('active-mo');
});
iconclose.addEventListener('click', ()=>{
    login.classList.remove('active-mo');
    if(login.classList.contains('active')){
        login.classList.remove('active');
    }
});

// luu tk ng dung

const dangky = document.querySelector('#nutdk');



dangky.addEventListener('click', (e)=>{
    e.preventDefault();
    let username = document.getElementById('tk');
    let email = document.getElementById('email');
    let password = document.getElementById('mk');
    

    localStorage.setItem('taiKhoan',username.value);
    localStorage.setItem('email',email.value);
    localStorage.setItem('matkhau',password.value);
    localStorage.setItem('date',Date());

    alert('Đăng ký thành công!');0
});
//dang nhap vao tk ng dung
let value = localStorage.getItem('taiKhoan');

let valuepass = localStorage.getItem('matkhau');

let logined =document.querySelector("#nutdn");

logined.addEventListener('click', (e)=>{
    e.preventDefault();
     let ten = document.getElementById('acc');

     let mat = document.getElementById('pass');

     if(ten.value == "admin"){
         window.location.href='admin.html'
     }
     else if(ten.value == value && mat.value == valuepass){
         window.location.href='logined.html'
     }
     else{
        console.log('cant sign in!')
     };
 });

