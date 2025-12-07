<script src="assets/extensions/jquery/jquery.min.js"></script>
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/static/js/pages/horizontal-layout.js"></script>
<script src="assets/compiled/js/app.js"></script>

<!-- Need: Apexcharts -->
<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/extensions/dayjs/dayjs.min.js"></script>
<script src="assets/static/js/pages/ui-apexchart.js"></script>
<script src="assets/static/js/pages/dashboard.js"></script>
<script>
    // Data dari PHP: nama paket & jumlah booking per paket
    let serviceLabels = <?= json_encode($chartServiceLabels); ?>;
    let serviceSeries = <?= json_encode($chartServiceSeries, JSON_NUMERIC_CHECK); ?>;

    let optionsServiceBookings = {
        series: serviceSeries,
        labels: serviceLabels,
        chart: {
            type: "donut", // kalau mau bar, ganti ke "bar"
            width: "100%",
            height: "350px",
        },
        legend: {
            position: "bottom",
        },
        colors: ["#435ebe", "#55c6e8", "#F97316", "#10B981", "#E11D48", "#6366F1"],
        plotOptions: {
            pie: {
                donut: {
                    size: "30%",
                },
            },
        },
    };

    var chartServiceBookings = new ApexCharts(
        document.getElementById("chart-service-bookings"),
        optionsServiceBookings
    );
    chartServiceBookings.render();
</script>
<script>
    // Data dari PHP (jumlah booking per status)
    let totalBookingPending = <?= (int)$totalBookingPending; ?>;
    let totalBookingDikonfirmasi = <?= (int)$totalBookingDikonfirmasi; ?>;
    let totalBookingSelesai = <?= (int)$totalBookingSelesai; ?>;

    let optionsBookingStatus = {
        series: [
            totalBookingPending,
            totalBookingDikonfirmasi,
            totalBookingSelesai,
        ],
        labels: [
            "Pending",
            "Dikonfirmasi",
            "Selesai",
        ],
        colors: ["#FFC107", "#17A2B8", "#28A745"],
        chart: {
            type: "donut",
            width: "100%",
            height: 350,
        },
        legend: {
            position: "bottom",
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "30%",
                },
            },
        },
    };

    let chartBookingStatus = new ApexCharts(
        document.getElementById("chart-booking-status"),
        optionsBookingStatus
    );
    chartBookingStatus.render();
</script>


<!-- Custom Sweet Alert 2 -->
<script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
<?php include 'sweetalert.php'; ?>

<!-- Choices -->
<script src="assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="assets/static/js/pages/form-element-select.js"></script>

<!-- Form Parsley -->
<script src="assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="assets/static/js/pages/parsley.js"></script>

<!-- Datetime Picker -->
<script src="assets/extensions/flatpickr/flatpickr.min.js"></script>
<script src="assets/static/js/pages/date-picker.js"></script>

<!-- Image Upload -->
<script src="assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
<script src="assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
<script src="assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
<script src="assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
<script src="assets/extensions/filepond/filepond.js"></script>
<script src="assets/extensions/toastify-js/src/toastify.js"></script>
<script src="assets/static/js/pages/filepond.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("iaggree");
        const buttonDeleteAccount = document.getElementById("btn-delete-account");

        if (checkbox && buttonDeleteAccount) { // Pastikan elemen ada
            checkbox.addEventListener("change", function() {
                const checked = checkbox.checked;
                if (checked) {
                    buttonDeleteAccount.removeAttribute("disabled");
                } else {
                    buttonDeleteAccount.setAttribute("disabled", true);
                }
            });
        }
    });
</script>



<!-- Datatables -->
<script src="assets/extensions/datatables/jquery.dataTables.min.js"></script>
<script src="assets/extensions/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/extensions/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/extensions/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/extensions/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/extensions/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/extensions/jszip/jszip.min.js"></script>
<script src="assets/extensions/pdfmake/pdfmake.min.js"></script>
<script src="assets/extensions/pdfmake/vfs_fonts.js"></script>
<script src="assets/extensions/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/extensions/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/extensions/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>