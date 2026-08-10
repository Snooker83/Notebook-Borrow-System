    </div> <!-- End Main Content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Responsive -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


    <!-- DataTables Config -->
    <script src="assets/js/datatables.js"></script>

    <script src="assets/js/alert.js"></script>

    <script src="../assets/js/confirm.js"></script>

    <!-- Live Clock -->
    <script>
        function updateClock() {

            const now = new Date();

            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            const clock = document.getElementById('live-clock');

            if (clock) {
                clock.innerHTML = now.toLocaleString('th-TH', options);
            }
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

    <!-- SweetAlert Success -->
    <?php if(isset($_SESSION['success'])): ?>

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: <?= json_encode($_SESSION['success']) ?>,
            timer: 2000,
            showConfirmButton: false
        });
    </script>

    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- SweetAlert Error -->
    <?php if(isset($_SESSION['error'])): ?>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: <?= json_encode($_SESSION['error']) ?>,
            confirmButtonText: 'OK'
        });
    </script>

    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>


<script>

window.successMessage = <?= json_encode($_SESSION['success'] ?? null) ?>;

window.errorMessage = <?= json_encode($_SESSION['error'] ?? null) ?>;

</script>

<?php

unset($_SESSION['success']);

unset($_SESSION['error']);

?>

    <!-- <script>

$(document).ready(function(){

    if($("#usersTable").length){

        $("#usersTable").DataTable({

            pageLength:10,

            responsive:true,

            ordering:true,

            searching:true,

            lengthChange:true,

            autoWidth:false

        });

    }

    if($("#notebookTable").length){

        $("#notebookTable").DataTable({

            pageLength:10,

            responsive:true,

            ordering:true,

            searching:true,

            lengthChange:true,

            autoWidth:false

        });

    }

    if($("#requestTable").length){

        $("#requestTable").DataTable({

            pageLength:10,

            responsive:true,

            ordering:true,

            searching:true,

            lengthChange:true,

            autoWidth:false

        });

    }

    if($("#borrowedTable").length){

        $("#borrowedTable").DataTable({

            pageLength:10,

            responsive:true,

            ordering:true,

            searching:true,

            lengthChange:true,

            autoWidth:false

        });

    }

});

</script> -->
</body>
</html>