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











// hiệu ứng đầu
 function but1(){
    document.getElementById('div1').style.display='block'
    document.getElementsByClassName("option").style.display='none'
    document.getElementById("quaylai").style.display='block'
}
function but2(){
    document.getElementById('div2').style.display='block'
    document.getElementsByClassName("option").style.display='none'
    document.getElementById("quaylai2").style.display='block'

}

// option 4 đáp án------------------------------------------------------------------------------------------------------------
function iteamtable(){
    let hoi = document.getElementById("hoi").value 
    let dapan_a = document.getElementById("dapan-a").value
    let dapan_b = document.getElementById("dapan-b").value
    let dapan_c = document.getElementById("dapan-c").value
    let dapan_d = document.getElementById("dapan-d").value
    let dapan_dung = document.getElementById("dapan-dung").value 
    let list_student = localStorage.getItem("list-student") ? JSON.parse(localStorage.getItem("list-student")) :[]
    list_student.push({
        hoi: hoi,
        dapan_a: dapan_a,
        dapan_b: dapan_b,
        dapan_c: dapan_c,
        dapan_d: dapan_d,
        dapan_dung: dapan_dung,
    })
    localStorage.setItem("list-student", JSON.stringify(list_student))
    render()
    load_i()
}

// in dữ liệu ra màn hình
function render(){
    let list_student = localStorage.getItem("list-student") ? JSON.parse(localStorage.getItem("list-student")) :[]
    let student = `
        <tr>
            <th>STT</th>
            <th>thời gian</th>
            <th>ND CÂU HỎI</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>ĐÁP ÁN</th>
            <TH>EDIT</TH>
        </tr>` 
        
    list_student.map((value, index,id)=>{
        student +=
        `<tr>  
            <td> ${index+1}</td> 
            <td>${id = new Date().toLocaleString()}</td>             
            <td>${value.hoi}</td>
            <td>${value.dapan_a}</td>
            <td>${value.dapan_b}</td>
            <td>${value.dapan_c}</td>
            <td>${value.dapan_d}</td>
            <td>${value.dapan_dung}</td>
            <td>
                <button type="button" class="newbtn" onclick="editstudent(${index})">Sửa</button>
                <button type="button" class="newbtn" onclick="delete2(${index})">Xóa</button>
            </td>
        </tr>`
    })
    document.getElementById("table-content").innerHTML=student
}

// sửa dữ liệu

function editstudent(index){
            
                let list_student = localStorage.getItem("list-student") ? JSON.parse(localStorage.getItem("list-student")) :[]
                document.getElementById("hoi").value= list_student[index].hoi
                document.getElementById("dapan-a").value= list_student[index].dapan_a
                document.getElementById("dapan-b").value= list_student[index].dapan_b
                document.getElementById("dapan-c").value= list_student[index].dapan_c
                document.getElementById("dapan-d").value= list_student[index].dapan_d
                document.getElementById("dapan-dung").value= list_student[index].dapan_dung
                document.getElementById("index").value= index
                update()
}
function update(){
    document.getElementById("update").style.display='block'
    document.getElementById("gui").style.display='none'

}


function changestudent(){
    let list_student = localStorage.getItem("list-student") ? JSON.parse(localStorage.getItem("list-student")) :[]
    let index = document.getElementById("index").value
    list_student[index]={
        hoi: document.getElementById("hoi").value,
        dapan_a: document.getElementById("dapan-a").value,
        dapan_b: document.getElementById("dapan-b").value,
        dapan_c: document.getElementById("dapan-c").value,
        dapan_d: document.getElementById("dapan-d").value,
        dapan_dung: document.getElementById("dapan-dung").value,
    }
    localStorage.setItem("list-student", JSON.stringify(list_student))
    render()
    document.getElementById("update").style.display='none'
    document.getElementById("gui").style.display='block'


}





// load lại ô input sau khi ấn gửi câu hỏi
function load_i(){
    document.getElementById("hoi").value=""
    document.getElementById("dapan-a").value=""
    document.getElementById("dapan-b").value=""
    document.getElementById("dapan-c").value=""
    document.getElementById("dapan-d").value=""
    document.getElementById("dapan-dung").value=""
}

// xóa dữ liệu

function delete2(index){
    let list_student = localStorage.getItem("list-student") ? JSON.parse(localStorage.getItem("list-student")) :[]
    list_student.splice(index,1)
    localStorage.setItem("list-student", JSON.stringify(list_student))
    render()

}
// quay lai phần chọn option
function quaylai(){
    document.getElementById('div1').style.display='none'
    document.getElementById("div2").style.display='none'
    document.getElementById('option').style.display='block'
    
}




// Option 2 đáp án---------------------------------------------------------------------------------------------------------------------:
function iteamtable2(){
    let hoi2 = document.getElementById("hoi2").value 
    let dapan_a2 = document.getElementById("dapan-a2").value
    let dapan_b2 = document.getElementById("dapan-b2").value
    let dapan_dung2 = document.getElementById("dapan-dung2").value 
    let list_student2 = localStorage.getItem("list-student2") ? JSON.parse(localStorage.getItem("list-student2")) :[]
    list_student2.push({
        hoi2: hoi2,
        dapan_a2: dapan_a2,
        dapan_b2: dapan_b2,
        dapan_dung2: dapan_dung2,
    })
    localStorage.setItem("list-student2", JSON.stringify(list_student2))
    render2()
    load_i2()
}
// in dữ liệu ra bảng

function render2(){
    let list_student2 = localStorage.getItem("list-student2") ? JSON.parse(localStorage.getItem("list-student2")) :[]
    let student2 = `
        <tr>
            <th>STT</th>
            <th>thời gian</th>
            <th>ND CÂU HỎI</th>
            <th>A</th>
            <th>B</th>
            <th>ĐÁP ÁN</th>
            <TH>EDIT</TH>
        </tr>` 
        
    list_student2.map((value, index,id)=>{
        student2 +=
        `<tr>  
            <td> ${index+1}</td> 
            <td>${id = new Date().toLocaleString()}</td>             
            <td>${value.hoi2}</td>
            <td>${value.dapan_a2}</td>
            <td>${value.dapan_b2}</td>
            <td>${value.dapan_dung2}</td>
            <td>
                <button type="button" class="newbtn" onclick="editstudent2(${index})">Sửa</button>
                <button type="button" class="newbtn" onclick="delete2a(${index})">Xóa</button>
            </td>
        </tr>`
    })
    document.getElementById("table-content2").innerHTML=student2
}

// sửa dữ liệu
function editstudent2(index){
            
            let list_student2 = localStorage.getItem("list-student2") ? JSON.parse(localStorage.getItem("list-student2")) :[]
            document.getElementById("hoi2").value= list_student2[index].hoi2
            document.getElementById("dapan-a2").value= list_student2[index].dapan_a2
            document.getElementById("dapan-b2").value= list_studen2[index].dapan_b2
            document.getElementById("dapan-dung2").value= list_student2[index].dapan_dung2
            document.getElementById("index2").value= index2
            update2()
}
function update2(){
document.getElementById("update2").style.display='block'
document.getElementById("gui2").style.display='none'

}

// 
function changestudent2(){
    let list_student2 = localStorage.getItem("list-student2") ? JSON.parse(localStorage.getItem("list-student2")) :[]
    let index2 = document.getElementById("index2").value
    list_student2[index]={
        hoi2: document.getElementById("hoi2").value,
        dapan_a2: document.getElementById("dapan-a2").value,
        dapan_b2: document.getElementById("dapan-b2").value,
        dapan_dung2: document.getElementById("dapan-dung2").value,
    }
    localStorage.setItem("list-student2", JSON.stringify(list_student2))
    render2()
    document.getElementById("update2").style.display='none'
    document.getElementById("gui2").style.display='block'


}
// load lại ô input sau khi ấn gửi câu hỏi
function load_i2(){
    document.getElementById("hoi2").value=""
    document.getElementById("dapan-a2").value=""
    document.getElementById("dapan-b2").value=""
    document.getElementById("dapan-dung2").value=""
}

// xóa dữ liệu

function delete2a(index){
    let list_student2 = localStorage.getItem("list-student2") ? JSON.parse(localStorage.getItem("list-student2")) :[]
    list_student2.splice(index,1)
    localStorage.setItem("list-student2", JSON.stringify(list_student2))
    render2()

}
// quay lai phần chọn option
function quaylai(){
    document.getElementById('div1').style.display='none'
    document.getElementById("div2").style.display='none'
    document.getElementById('option').style.display='block'
    
}