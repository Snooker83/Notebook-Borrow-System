// ==========================================
// Notebook Borrow System
// Login Validation
// ==========================================


document.addEventListener(
    "DOMContentLoaded",
    function(){


    const form =
    document.getElementById("loginForm");


    const email =
    document.getElementById("email");


    const password =
    document.getElementById("password");



    form.addEventListener(
        "submit",
        function(e){



            let emailValue =
            email.value.trim();



            // ตรวจสอบ Email

            if(emailValue === ""){


                alert(
                    "Please enter CMU Email"
                );


                e.preventDefault();

                return;


            }




            // เติม @cmu.ac.th อัตโนมัติ

            if(
                !emailValue.includes("@cmu.ac.th")
            ){


                email.value =
                emailValue + "@cmu.ac.th";


            }





            // ตรวจ Password


            if(password.value.length < 8){


                alert(
                    "Password must be at least 8 characters"
                );


                e.preventDefault();


                return;


            }



        }
    );



});