<?php
session_start();
if (isset($_SESSION['userType'])) {


    include '../elements/header.php';
    include '../elements/navbar.php';
    include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';
    include 'viewReport.php';
    include '../elements/footer.php';

?>
    <!-- DataTables -->
    <link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../vendor/plugins/datatables-buttons/css/buttons.dataTables.min.css">
    <!-- DataTables -->
    <script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/plugins/datatables/date-eu.js"></script>
    <script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../vendor/plugins/jszip/jszip.min.js"></script>
    <script src="../../vendor/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../vendor/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../vendor/plugins/datatables-buttons/js/buttons.html5.min.js"></script>

    <script>
        $("#navReportTree").addClass("menu-open");
        $("#navReport").addClass("active");
        $("#navViewReport").addClass("active");

        var table;

        $(function() {
            table = $('#tableReport').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy" style="color: #4285F4;"></i>&nbsp;&nbsp;Copy',
                        titleAttr: 'Copy',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel" style="color: #4285F4;"></i>&nbsp;&nbsp;Excel',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv" style="color: #4285F4;"></i>&nbsp;&nbsp;CSV',
                        titleAttr: 'CSV',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" style="color: #4285F4;"></i>&nbsp;&nbsp;PDF',
                        titleAttr: 'PDF',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        },
                    }
                ],
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [
                    [1, "asc"]
                ]
            });
        });

        function viewReport(id) {
            window.open('reportDetails.php?reportID=' + id, '_self');
        }

        function editReport(id) {
            window.open('editReport.php?reportID=' + id, '_self');
        }

        function deleteReport(id) {

            var alertText = "";
            var deleteUrl = "";
            deleteUrl = "../../assets/php/reportRemove.php";
            alertText = "The Report would be removed from the database!"

            swal({
                    title: "Are you sure?",
                    text: alertText,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: deleteUrl,
                            data: {
                                reportID: id
                            },
                            beforeSend: function() {
                                $('.loader').fadeIn();
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.trim() == "success") {
                                    $('.loader').fadeOut();
                                    swal("Success!", "Deletion successful!", "success");
                                    table.row($('.datatable-report-' + id)).remove().draw();
                                } else {
                                    $('.loader').fadeOut();
                                    swal("Error!", "An error occurred, please try again!", "error");
                                }
                            }
                        });
                    }
                });
        }
    </script>
    <style media="screen">
        .expiring {
            background-color: #FFA726;
        }

        .expired {
            background-color: #EF5350;
        }
    </style>
<?php

} else {
?>
    <script>
        window.open('../../', '_self')
    </script>
<?php
}


?>