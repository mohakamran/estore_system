<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'dashboard-v'.$_SESSION['userType'].'.php';
  include '../elements/footer.php';

  ?>
  <!-- InputMask -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- date-range-picker -->
  <script src="../../vendor/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Chart JS -->
  <script src="../../vendor/plugins/chart.js/Chart.min.js"></script>
  <script>

  $("#navDashboard").addClass("active");


  var sales;
  var invoices;

  $(document).ready(function(){

    $.ajax({
      type: 'POST',
      url: "../../assets/php/getInvoices.php",
      data: {
        empId : <?php echo json_encode($_SESSION['id']); ?>,
        fromDate : moment().subtract(5, 'month').startOf('month').format('YYYY-MM-DD')
      },
      success: function(data) {
        obj = jQuery.parseJSON(data);
        assembleSalesData(obj)
      }
    });

    $.ajax({
      type: 'POST',
      url: "../../assets/php/getInvoices.php",
      data: {
        empId : <?php echo json_encode($_SESSION['id']); ?>,
        fromDate : moment().subtract(13, 'days').format('YYYY-MM-DD')
      },
      success: function(data) {
        obj = jQuery.parseJSON(data);
        assembleInvoiceData(obj)
      }
    });

  });

  function assembleInvoiceData(obj){

    $("#totalInvoiceData").html(obj.length);

    invoices = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];

    var invoicesLastWeek = 0;
    var invoicesThisWeek = 0;

    var nowDate = moment().format('YYYY-MM-DD');
    var d1 = new Date(nowDate);

    for(var i = 0; i < obj.length; i++){
      var d2 = new Date(obj[i].invoiceDate);
      var d3 = new Date(d1 - d2);
      var index = d3/1000/60/60/24;
      invoices[index] = parseInt(invoices[index]) + 1;
    }

    for(var i = 0; i < 7; i++){
      invoicesThisWeek = invoicesThisWeek + invoices[i];
    }
    for(var i = 7; i < 14; i++){
      invoicesLastWeek = invoicesLastWeek + invoices[i];
    }

    if(invoicesThisWeek > invoicesLastWeek){
      $("#invoiceChange").html('<span class="text-success inv"><i class="fas fa-arrow-up"></i> '+(((invoicesThisWeek-invoicesLastWeek)/invoicesLastWeek)*100).toFixed(2)+'%</span>');
    }else if(invoicesThisWeek < invoicesLastWeek){
      $("#invoiceChange").html('<span class="text-danger inv"><i class="fas fa-arrow-down"></i> '+(((invoicesLastWeek-invoicesThisWeek)/invoicesLastWeek)*100).toFixed(2)+'%</span>');
    }

    if($(".inv").text().trim() == 'Infinity%'){
      $(".inv").text('0.0%');
    }

    loadInvoiceData()
  }

  function assembleSalesData(obj){

    var TotalSale = 0;
    sales = [0,0,0,0,0,0,0,0,0,0,0,0];

    for(var i = 0; i < obj.length; i++){
      TotalSale = TotalSale + parseFloat(obj[i].total);
      var d = new Date(obj[i].invoiceDate);
      var m = d.getMonth() + 1;
      sales[m] = parseInt(sales[m]) + parseInt(obj[i].total);
    }
    if(sales[moment().subtract(1, 'month').format('M')] > sales[moment().format('M')] ){
      $("#salesChange").html('<span class="text-danger sales"><i class="fas fa-arrow-down"></i> '+(((sales[moment().subtract(1, 'month').format('M')] - sales[moment().format('M')]) * 100 ) / sales[moment().subtract(1, 'month').format('M')]).toFixed(2)+'%</span>')
    }else{
      $("#salesChange").html('<span class="text-success sales"><i class="fas fa-arrow-up"></i> '+(((sales[moment().format('M')] - sales[moment().subtract(1, 'month').format('M')]) * 100 ) / sales[moment().subtract(1, 'month').format('M')]).toFixed(2)+'%</span>')
    }
    if($(".sales").text().trim() == 'Infinity%'){
      $(".sales").text('0.0%');
    }
    $("#totalSalesData").html(parseFloat(TotalSale).toFixed(2))
    loadSalesData()
  }

  function loadSalesData() {
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var salesData = [
      sales[moment().subtract(5, 'month').format('M')],
      sales[moment().subtract(4, 'month').format('M')],
      sales[moment().subtract(3, 'month').format('M')],
      sales[moment().subtract(2, 'month').format('M')],
      sales[moment().subtract(1, 'month').format('M')],
      sales[moment().format('M')]
    ]

    var mode      = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    var salesChart  = new Chart($salesChart, {
      type   : 'bar',
      data   : {
        labels  : [
          moment().subtract(5, 'month').format('MMM').toUpperCase(),
          moment().subtract(4, 'month').format('MMM').toUpperCase(),
          moment().subtract(3, 'month').format('MMM').toUpperCase(),
          moment().subtract(2, 'month').format('MMM').toUpperCase(),
          moment().subtract(1, 'month').format('MMM').toUpperCase(),
          moment().format('MMM').toUpperCase()
        ],
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           : salesData
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }
                return '£' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })
  }

  function loadInvoiceData() {
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
    var mode      = 'index'
    var intersect = true

    var $visitorsChart = $('#invoice-chart')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : [
          moment().subtract(6, 'days').format('D-MMM'),
          moment().subtract(5, 'days').format('D-MMM'),
          moment().subtract(4, 'days').format('D-MMM'),
          moment().subtract(3, 'days').format('D-MMM'),
          moment().subtract(2, 'days').format('D-MMM'),
          moment().subtract(1, 'days').format('D-MMM'),
          moment().format('D-MMM')
        ],
        datasets: [{
          type                : 'line',
          data                : [
            invoices[6],
            invoices[5],
            invoices[4],
            invoices[3],
            invoices[2],
            invoices[1],
            invoices[0]
          ],
          backgroundColor     : 'transparent',
          borderColor         : '#007bff',
          pointBorderColor    : '#007bff',
          pointBackgroundColor: '#007bff',
          fill                : false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
        {
          type                : 'line',
          data                : [
            invoices[13],
            invoices[12],
            invoices[11],
            invoices[10],
            invoices[9],
            invoices[8],
            invoices[7]
          ],
          backgroundColor     : 'tansparent',
          borderColor         : '#ced4da',
          pointBorderColor    : '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill                : false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
              suggestedMax: Math.max.apply(Math,invoices)
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })
  }


  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
