$(document).ready(function () {

    // ตรวจสอบว่ามี DataTables หรือไม่
    if (typeof $.fn.DataTable === "undefined") {
        return;
    }

    // กำหนดค่าเริ่มต้นให้ DataTables ทุกตัว
    $(".datatable").DataTable({

        responsive: true,

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],

        autoWidth: false,

        ordering: true,

        searching: true,

        lengthChange: true

        // language: {
        //     url: "https://cdn.datatables.net/plug-ins/2.3.3/i18n/th.json"
        // }

    });

});