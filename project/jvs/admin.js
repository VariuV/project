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
  function danhsach4(){
    document.getElementById("ds4").style.display='block'
    document.getElementById("ds2").style.display='none'
    
}
function danhsach2(){
    document.getElementById("ds2").style.display='block'
    document.getElementById("ds4").style.display='none'
    
}


// OPTION 4 câu hỏi---------------------------------------->
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
            <th>TRẠNG THÁI</th>
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
            <td>${value.cho_duyet}</td>
            <td>
                <button type="button" onclick="addnew(${index})" >Duyệt</button>
                <button type="button" onclick="">Không duyệt</button>
            </td>
        </tr>`
    })
    document.getElementById("table-content").innerHTML=student
    render2()
}








//    OPTION 2 CÂU HỎI


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
            <th>TRẠNG THÁI</th>
            <TH>EDIT</TH>
        </tr>` 
        
    list_student2.map((value, index,id,)=>{
        student2 +=
        `<tr>  
            <td> ${index+1}</td> 
            <td>${id = new Date().toLocaleString()}</td>             
            <td>${value.hoi2}</td>
            <td>${value.dapan_a2}</td>
            <td>${value.dapan_b2}</td>
            <td>${value.dapan_dung2}</td>
            <td id="duyet">${value.cho_duyet2}</td>
            <td>
                <button type="button" ">Duyệt</button>
                <button type="button" onclick="">Không duyệt</button>
            </td>
        </tr>`
    })
    document.getElementById("table-content2").innerHTML=student2
}

  

    