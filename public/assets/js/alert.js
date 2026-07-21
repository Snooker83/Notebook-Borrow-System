document.addEventListener("DOMContentLoaded", function () {

    if (typeof flashSuccess !== "undefined" && flashSuccess) {

        Swal.fire({
            icon: "success",
            title: "Success",
            text: flashSuccess,
            confirmButtonColor: "#6C5CE7"
        });

    }

    if (typeof flashError !== "undefined" && flashError) {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: flashError,
            confirmButtonColor: "#6C5CE7"
        });

    }

});