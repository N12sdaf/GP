
    function toDash(){
        window.location.href = "dashboard.php";
    
    }
    
    function toRequest(){
        window.location.href = "patient_history.php";
    
    }
    
    const Email_form = document.getElementById("Email_form");
    const open_email_sender = document.getElementById("open_email_sender");
    const close_email_sender = document.getElementById("close_email_sender");
     open_email_sender.addEventListener("click", function () {
            Email_form.style.display = "block";
            
        });
        close_email_sender.addEventListener("click", function () {
            Email_form.style.display = "none";
            
        });
        
    const inertdocform = document.getElementById("inertdocform");
    const open_doctor_insert = document.getElementById("open_doctor_insert");
    const close_doctor_insert = document.getElementById("close_doctor_insert");
        
        open_doctor_insert.addEventListener("click", function () {
            inertdocform.style.display = "block";
           
        });
        close_doctor_insert.addEventListener("click", function (){
            inertdocform.style.display = "none";
            });
    
    const inertPatientform = document.getElementById("inertpatientform");
    const open_patient_insert = document.getElementById("open_patient_insert");
    const close_patient_insert = document.getElementById("close_patient_insert");
        
        open_patient_insert.addEventListener("click", function () {
            inertPatientform.style.display = "block";
           
        });
        close_patient_insert.addEventListener("click", function (){
            inertPatientform.style.display = "none";
            });
    
    const removedocform = document.getElementById("removedocform");
    const open_doctor_remove = document.getElementById("open_doctor_remove");
    const close_doctor_remove = document.getElementById("close_doctor_remove");
                
                open_doctor_remove.addEventListener("click", function () {
                    removedocform.style.display = "block";
                   
                });
                close_doctor_remove.addEventListener("click", function (){
                    removedocform.style.display = "none";
                    });

const ChangeDocAreaForm = document.getElementById("ChangeDocAreaForm");
const open_doctor_change = document.getElementById("open_doctor_change");
const close_doctor_change = document.getElementById("close_doctor_change");
                                
                open_doctor_change.addEventListener("click", function () {
                    ChangeDocAreaForm.style.display = "block";
                                   
                                });
                close_doctor_change.addEventListener("click", function (){
                    ChangeDocAreaForm.style.display = "none";
                                });
    
    
    const lowform = document.getElementById("lowform");
    const medform = document.getElementById("medform");
    const highform = document.getElementById("highform");
    
    const lowop = document.getElementById("addl");
    const medop = document.getElementById("addm");
    const highop = document.getElementById("addh");
    
    const lowcl = document.getElementById("close_low");
    const medcl = document.getElementById("close_med");
    const highcl = document.getElementById("close_high");
        lowop.addEventListener("click", function () {
            lowform.style.display = "block";
           
        });
        medop.addEventListener("click", function () {
            medform.style.display = "block";
           
        });
        highop.addEventListener("click", function () {
            highform.style.display = "block";
           
        });
        
        lowcl.addEventListener("click", function () {
            lowform.style.display = "none";
           
        });
        medcl.addEventListener("click", function () {
            medform.style.display = "none";
           
        });
        highcl.addEventListener("click", function () {
            highform.style.display = "none";
           
        });
        
       
    function generatePassword() {
        var length = 10; 
        var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_";
        var password = "";
            for (var i = 0; i < length; ++i) {
                var randomChar = charset.charAt(Math.floor(Math.random() * charset.length));
                password += randomChar;
            }
            document.getElementById("password").value = password;
        }
        
    