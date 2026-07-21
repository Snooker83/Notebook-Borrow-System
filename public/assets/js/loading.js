// ==========================================
// Global Loading Dialog
// ==========================================

function showLoading(title = "Please wait...", text = "Processing your request") {

    Swal.fire({

        title: title,

        text: text,

        allowOutsideClick: false,

        allowEscapeKey: false,

        showConfirmButton: false,

        didOpen: () => {

            Swal.showLoading();

        }

    });

}

function hideLoading() {

    Swal.close();

}