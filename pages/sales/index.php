<?php
session_start();
if(isset($_SESSION['userType'])){

  include '../elements/header.php';
  ?>
<!-- daterange picker -->
<link rel="stylesheet" href="../../vendor/plugins/daterangepicker/daterangepicker.css">
<?php
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'viewSales.php';
  include '../elements/footer.php';

  ?>
<!-- InputMask -->
<script src="../../vendor/plugins/moment/moment.min.js"></script>
<script src="../../vendor/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../vendor/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Page script -->
<script>
var userType = '<?=$_SESSION['userType']; ?>';

$("#navSales").addClass("active");

var dateStart = moment().startOf('month').format('YYYY-MM-DD');
var dateEnd = moment().endOf('month').format('YYYY-MM-DD');

$(function() {
    //Date range as a button
    $('#daterange-btn').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month')
        },
        function(start, end) {
            dateStart = start.format('YYYY-MM-DD');
            dateEnd = end.format('YYYY-MM-DD');
        }
    )
});

function viewSalary() {
    if (userType == '0') {
        window.open('employeeSales.php?start=' + dateStart + '&end=' + dateEnd, '_self')
    } else {
        window.open('sales.php?start=' + dateStart + '&end=' + dateEnd, '_self')
    }
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