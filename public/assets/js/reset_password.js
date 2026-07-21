document.addEventListener("DOMContentLoaded",()=>{

    const form=document.getElementById("resetForm");

    const password=document.getElementById("password");

    const confirm=document.getElementById("confirm_password");

    form.addEventListener("submit",function(e){

        if(password.value.length<8){

            e.preventDefault();

            Swal.fire({

                icon:"warning",

                title:"Weak Password",

                text:"Password must be at least 8 characters."

            });

            return;

        }

        if(password.value!==confirm.value){

            e.preventDefault();

            Swal.fire({

                icon:"error",

                title:"Password Mismatch",

                text:"Passwords do not match."

            });

            return;

        }

        showLoading(

            "Resetting Password...",

            "Please wait"

        );

    });

});