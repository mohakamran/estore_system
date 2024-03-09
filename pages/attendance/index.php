<?php
session_start();
date_default_timezone_set('GMT');
$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$currentHour = date('H');
if(isset($_SESSION['userType'])){


  include '../elements/header.php';

  ?>
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-bootstrap/main.min.css">
  <?php

  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'markAttendance.php';
  include '../elements/footer.php';

  ?>

  <!-- fullCalendar 2.2.5 -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-daygrid/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-timegrid/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-interaction/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-bootstrap/main.min.js"></script>
  <!-- Page specific script -->
  <script>

  $(document).ready(function(){
    $.ajax({
      type: 'POST',
      url: "../../assets/php/getCurrentAttendance.php",
      success: function(response) {
        $("#attendanceMarkCard").html(response);
      }
    });
  });


  $(function () {

    var employeeID = "<?=$_SESSION['id'] ?>";
    var calendarDates = [];

    /* initialize the calendar
    -----------------------------------------------------------------*/
    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById('calendar');
    var index = 0;

    $.ajax({
      type: 'POST',
      url: "../../assets/php/getAttendance.php",
      data: {
        empID: employeeID
      },
      dataType: "json",
      success: function(response) {
        for (var i = 0; i < response.length; i++){
          var calendarDate = new Object();
          calendarDate.title = "Present - " + parseFloat(response[i].duration).toFixed(2) + " Hrs";
          calendarDate.allDay = true;
          calendarDate.start = new Date(response[i].date);
          calendarDate.backgroundColor = '#00C851';
          calendarDate.borderColor = '#00C851';
          calendarDates[i] = calendarDate;
          index++;
        }

        var calendar = new Calendar(calendarEl, {
          plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
          header    : {
            left  : 'title',
            center: '',
            right : 'prev,next today'
          },
          'themeSystem': 'bootstrap',
          //Random default events
          events    : calendarDates,
          editable  : false,
          droppable : false,
          showNonCurrentDates: false
        });
        calendar.render();
      }
    });

  });



  $("#navAttendance").addClass("active");


  function markAttendance() {

  $.ajax({
    type: 'POST',
    url: "../../assets/php/addAttendance.php",
    beforeSend: function() {
      $('.loader').fadeIn();
    },
    success: function(response) {
      console.log(response);
      if ( response.trim() == "success" ){
        $('.loader').fadeOut();
        swal("Success!", "Attendance Marked!", "success")
        .then((value) => {
          location.reload();
        });
      }else {
        $('.loader').fadeOut();
        swal("Error!", "An error occurred, please try again!", "error");
      }
    }
  });

}

</script>
<?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
