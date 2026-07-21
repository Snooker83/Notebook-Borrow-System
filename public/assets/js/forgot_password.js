document.addEventListener("DOMContentLoaded", () => {

    const form =
        document.getElementById("forgotForm");

    const prefix =
        document.getElementById("email_prefix");

    const email =
        document.getElementById("email");

    form.addEventListener("submit", function(e){

        if(prefix.value.trim()===""){

            e.preventDefault();

            Swal.fire({

                icon:"warning",

                title:"CMU Email Required",

                text:"Please enter your CMU Email."

            });

            return;

        }

        email.value =
            prefix.value.trim() + "@cmu.ac.th";

        showLoading(

            "Sending OTP...",

            "Please wait"

        );

    });

});