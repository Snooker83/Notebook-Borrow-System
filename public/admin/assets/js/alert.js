document.addEventListener("DOMContentLoaded", function () {

    if (typeof Swal === "undefined") {
        return;
    }

    // Success
    if (window.successMessage) {

        Swal.fire({

            icon: "success",

            title: "Success",

            text: window.successMessage,

            confirmButtonColor: "#198754"

        });

    }

    // Error
    if (window.errorMessage) {

        Swal.fire({

            icon: "error",

            title: "Error",

            text: window.errorMessage,

            confirmButtonColor: "#dc3545"

        });

    }

});