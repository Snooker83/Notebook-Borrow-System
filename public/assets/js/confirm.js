// ==========================================
// Global Confirm Dialog
// ==========================================

function confirmAction(options) {

    return Swal.fire({

        title: options.title ?? "Are you sure?",

        text: options.text ?? "This action cannot be undone.",

        icon: options.icon ?? "warning",

        showCancelButton: true,

        confirmButtonColor: "#6C5CE7",

        cancelButtonColor: "#6C757D",

        confirmButtonText: options.confirmText ?? "Yes",

        cancelButtonText: options.cancelText ?? "Cancel",

        reverseButtons: true

    });

}

// ==========================================
// Auto Confirm Links
// ==========================================

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll("[data-confirm]").forEach(button => {

        button.addEventListener("click", function(e){

            e.preventDefault();

            const url = this.href;

            confirmAction({

                title: this.dataset.title,

                text: this.dataset.text,

                icon: this.dataset.icon,

                confirmText: this.dataset.confirm

            }).then(result => {

                if(result.isConfirmed){

                    window.location.href = url;

                }

            });

        });

    });

});