const login = document.querySelector('.login');
const loginlink = document.querySelector('.login-link');
const reglink = document.querySelector('.register-link');
const iconclose = document.querySelector('.nuttat');
const dangnhappre = document.querySelector('.nut1');
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


dangnhappre.addEventListener('click',(e)=>{
    e.preventDefault();
});



iconclose.addEventListener('click', ()=>{
    login.classList.remove('active-mo');
    if(login.classList.contains('active')){
        login.classList.remove('active');
    }
});