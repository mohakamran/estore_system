<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'viewInvoices.php';
  include '../elements/footer.php';

  ?>

<style media="screen">
.dt-24-h {
    background-color: #EF5350 !important;
}

.dt-72-h {
    background-color: #FFA726 !important;
}

.invoice-paid {
    background-color: #62cc8d !important;
}
</style>

<!-- DataTables -->
<link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../vendor/plugins/datatables-buttons/css/buttons.dataTables.min.css">
<!-- DataTables -->
<script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../vendor/plugins/jszip/jszip.min.js"></script>
<script src="../../vendor/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../vendor/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../vendor/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script>
$("#navInvoiceTree").addClass("menu-open");
$("#navInvoice").addClass("active");
$("#navViewInvoiceRecurring").addClass("active");

var table;

$(function() {
    table = $('#tableInvoice').DataTable({
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
    });
});

function viewInvoice(id) {
    window.open('../invoiceRecurred?invoice=' + id, '_blank')
}

function editInvoice(id) {
    window.open('../invoiceEdit?invoice=' + id, '_blank')
}

function deleteInvoice(id) {

    var alertText = "";
    var deleteUrl = "";
    deleteUrl = "../../assets/php/invoiceRecurringStop.php";
    alertText = "The Invoice auto-generation would be stopped!"

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
                        invoiceID: id
                    },
                    beforeSend: function() {
                        $('.loader').fadeIn();
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.trim() == "success") {
                            $('.loader').fadeOut();
                            swal("Success!", "Operation successful!", "success");
                            table.row($('.datatable-invoice-' + id)).remove().draw();
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
<?php

}else{
  ?>
<script>
window.open('../../', '_self')
</script>
<?php
}


?>