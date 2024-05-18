var low=document.getElementById("low");
var high=document.getElementById("high");
var med=document.getElementById("med");
var total_patient=document.getElementById("total_patient");
var avareg=document.getElementById("avareg");
var req_butt=document.getElementById("P_info_butt");
var Dash_butt=document.getElementById("dash_butt");

function toDash(){
    window.location.href = "dashbord_frame.html";

}

function toRequest(){
    window.location.href = "request_Info_frame.html";

}

function getHigh() {
    fetch('get_Numbers.php')
        .then(response => response.json())
        .then(data => {
           
            const columnCount = data.column_count;
            console.log(columnCount);
            high.textContent =columnCount;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            high.textContent=`error`
        });
}


getHigh();