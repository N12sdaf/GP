document.addEventListener("DOMContentLoaded", function () {
  emailjs.init("F9d7D2XwkSLDnDifR");

  const emailResultDiv = document.getElementById("emailResult");
  const otpVerify = document.querySelector(".otpverfiy");
  const otpDiv = document.getElementById("otpResult");

  function sendOTPEmail() {
    const userId = document.getElementById("userId").value;
    let otp = Math.floor(1000 + Math.random() * 9000);

    emailResultDiv.innerHTML = "";

    fetch(`get_email.php?userId=${userId}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.exists) {
          const userEmail = data.email;

          emailjs
            .send("service_y93wki4", "template_rpsy8o1", {
              from_email: "selftraige22@gmail.com",
              to_email: userEmail,
              subject: "ID Verify",
              message: "Hello, Your OTP is: " + otp,
              Body: "Your OTP is: " + otp,
            })
            .then(
              function (response) {
                console.log("Email sent successfully:", response);

                otpVerify.style.display = "block";
                const otpInput = document.getElementById("otp_inp");
                const button2 = document.getElementById("otp1");

                button2.addEventListener("click", () => {
                  if (otpInput.value == otp) {
                    emailResultDiv.innerHTML = "";
                    const redirectURL = `frame5AR.html?userId=${
                      document.getElementById("userId").value
                    }`;
                    window.location.href = redirectURL;
                  } else {
                    otpDiv.innerHTML = "<div class='alert alert-danger d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg><div> رقم التحقق غير صحيح   </div></div>";
                  } 
                });
              },
              function (error) {
                console.error("Email delivery failed:", error);
                alert("فشل ارسال الايميل.");
              }
            );
        } else {
          emailResultDiv.innerHTML = "<div class='alert alert-danger d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg><div>رقم الهوية غير مسجل بالنظام</div></div>";

        }
      })
      .catch((error) => {
        console.error(error);
        emailResultDiv.innerHTML = "<div class='alert alert-danger d-flex align-items-center' role='alert'><svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg><div>حدث خطأ  </div></div>";
      });
  }

  document.getElementById("submit").addEventListener("click", function (event) {
    event.preventDefault();
    sendOTPEmail();
  });
});
