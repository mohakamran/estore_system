<?php
session_start();
date_default_timezone_set('GMT');
$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$currentHour = date('H');
if(isset($_SESSION['userType'])){

  $empID = $_GET['empID'];

  include '../elements/header.php';

  ?>

  <!-- fullCalendar -->
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/fullcalendar-bootstrap/main.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <?php

  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include 'employeeDetail.php';
  include '../elements/footer.php';

  ?>
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <!-- fullCalendar 2.2.5 -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-daygrid/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-timegrid/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-interaction/main.min.js"></script>
  <script src="../../vendor/plugins/fullcalendar-bootstrap/main.min.js"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="../../vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- DataTables -->
  <script src="../../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Croppie -->
  <link rel="stylesheet" href="../../vendor/plugins/croppie/croppie.css">
  <script src="../../vendor/plugins/croppie/croppie.min.js"></script>
  <!-- Page specific script -->
  <script>

  $("#navEmployeeTree").addClass("menu-open");
  $("#navEmployee").addClass("active");
  $("#navViewEmployee").addClass("active");

  var eventsPresent = false;
  var eventsRecorded = false;
  var employeeID = "<?=$empID ?>";
  var sessionID = "<?=$_SESSION['id']?>";
  var userType = "<?=$_SESSION['userType']?>";
  var obj = [];

  $(document).ready(function(){

    //Attendance update validation
    $('#attendanceUpdateForm').validate({
      submitHandler: function () {
        updateAttendance();
      },
      rules: {
        inTimePickerInput: {
          required: true
        },
        outTimePickerInput: {
          required: true
        },
      },
      messages: {
        inTimePickerInput: {
          required: "Please enter In-Time"
        },
        outTimePickerInput: {
          required: "Please enter Out-Time"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

  });


  $(function () {

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
          var attendanceTime = response[i].duration * 60;
          var calendarDate = new Object();
          calendarDate.title = parseInt(attendanceTime/60) + "H " + parseInt(attendanceTime%60) + "m";
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
          showNonCurrentDates: false,
          datesRender: function (info) {
            if(eventsPresent){
              eventsPresent = false;
            }else{
              $("#attendanceCount").val('0')
              $("#totalHours").val('0H 0m')
            }
            eventsRecorded = false;
          },
          dateClick: function(info) {
            getAttendanceDetails(info.dateStr)
          },
          eventRender: function (event, eventElement){

            if(!eventsRecorded){
              eventsRecorded = true;
              $("#attendanceCount").val('0');
              $("#totalHours").val('0H 0m');
            }
            eventsPresent = true;
            var attendanceCount = parseInt($("#attendanceCount").val());
            $("#attendanceCount").val(attendanceCount + 1);
            var timeCount = $("#totalHours").val().split(" ");
            timeCountValue = parseInt((timeCount[0]).replace(/[^\d.]/g, '')*60) + parseInt((timeCount[1]).replace(/[^\d.]/g, ''));
            var eventTime = (event.event._def.title).split(" ");
            eventTimeValue = parseInt((eventTime[0]).replace(/[^\d.]/g, '')*60) + parseInt((eventTime[1]).replace(/[^\d.]/g, ''));
            var totalTime = timeCountValue + eventTimeValue;
            $("#totalHours").val(parseInt(totalTime/60) + "H " + parseInt(totalTime%60) + "m");
          },
        });
        calendar.render();
      }
    });
  });

  function getAttendanceDetails(date){
    $("#attendanceTitle").html("Attendance - " + date);
    $(".overlayContent").html('<div class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-2x fa-sync fa-spin"></i></div>');
    $("#attendanceModal").html('<p>Loading Data&hellip;</p>');
    $("#modalButton").trigger('click');
    $.ajax({
      type: 'POST',
      url: "../../assets/php/getAttendanceDetails.php",
      data: {
        empID: employeeID,
        attendanceDate: date
      },
      success: function(data) {
        obj = [];
        $(".overlayContent").html('');
        obj = jQuery.parseJSON(data);
        if(obj.length > 0){
          $("#attendanceExists").val(obj[0].id)
          $("#attendanceModal").html('<input id="attendanceDateUpdate" value="'+date+'" hidden/><div class="form-group"> <label>In-Time</label> <div class="input-group date inTimePicker" id="inTimePicker" data-target-input="nearest"> <input type="text" id="inTimePickerInput" value="'+obj[0].inTime+'" name="inTimePickerInput" class="form-control datetimepicker-input" data-target=".inTimePicker"/> <div class="input-group-append" data-target=".inTimePicker" data-toggle="datetimepicker"> <div class="input-group-text"><i class="far fa-clock"></i></div></div></div></div><div class="form-group"> <label>Out-Time</label> <div class="input-group date outTimePicker" id="outTimePicker" data-target-input="nearest"> <input type="text" id="outTimePickerInput" value="'+obj[0].outTime+'" name="outTimePickerInput" class="form-control datetimepicker-input" data-target=".outTimePicker"/> <div class="input-group-append" data-target=".outTimePicker" data-toggle="datetimepicker"> <div class="input-group-text"><i class="far fa-clock"></i></div></div></div></div>');
        }else{
          $("#attendanceExists").val('-1');
          $("#attendanceModal").html('<input id="attendanceDateUpdate" value="'+date+'" hidden/><div class="form-group"> <label>In-Time</label> <div class="input-group date inTimePicker" id="inTimePicker" data-target-input="nearest"> <input type="text" id="inTimePickerInput" name="inTimePickerInput" class="form-control datetimepicker-input" data-target=".inTimePicker"/> <div class="input-group-append" data-target=".inTimePicker" data-toggle="datetimepicker"> <div class="input-group-text"><i class="far fa-clock"></i></div></div></div></div><div class="form-group"> <label>Out-Time</label> <div class="input-group date outTimePicker" id="outTimePicker" data-target-input="nearest"> <input type="text" id="outTimePickerInput" name="outTimePickerInput" class="form-control datetimepicker-input" data-target=".outTimePicker"/> <div class="input-group-append" data-target=".outTimePicker" data-toggle="datetimepicker"> <div class="input-group-text"><i class="far fa-clock"></i></div></div></div></div>');
        }
        $('.date').datetimepicker({
          format: 'LT'
        });

      }
    });
  }

  function updateAttendance(){
    $('.loader').fadeIn();
    $.ajax({
      type: 'POST',
      url: "../../assets/php/attendanceUpdate.php",
      data: {
        empID: employeeID,
        attendanceDate: $("#attendanceDateUpdate").val(),
        attendanceID: $("#attendanceExists").val(),
        inTime: moment($("#inTimePickerInput").val(), ["h:mm A"]).format("HH:mm:ss"),
        outTime: moment($("#outTimePickerInput").val(), ["h:mm A"]).format("HH:mm:ss")
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Attendance Updated!", "success")
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

  $(document).ready(function() {
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
      $($.fn.dataTable.tables( true ) ).css('width', '100%');
      $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
    } );
  });


  $( document ).ready(function() {

    var image_crop;

    $("#removePicture").on("click", function(){
      $('#modal-sm').modal('hide');
      $('.loader').fadeIn();
      $.ajax({
        url:"../../assets/php/removePicture.php",
        type: "POST",
        data:{
          employeeID : employeeID
        },
        success:function(data)
        {
          console.log(data);;
          if(data == "success"){
            $('.loader').fadeOut();
            swal("Success!", "Profile picture removed!", "success")
            .then((value) => {
              $(".profile-user-img").attr("src", "../../assets/images/avatar0.png?"+Date.now());
              $(".sidebarprofilePicture").attr("src", "../../assets/images/avatar0.png?"+Date.now());
            });
          }else {
            $('.loader').fadeOut();
            swal("Error!", "An error occurred, please try again!", "error");
          }
        }
      });
    });

    $(".profile-user-img").on('click', function(){
      if(employeeID == sessionID || userType == "0"){
        $("#smallModal").trigger('click');
      }
    });


    $("#changePicture").on('click', function(){
      if(employeeID == sessionID || userType == "0"){
        $('#modal-sm').modal('hide');
        $('#upload').val('');
        $("#upload").trigger('click');
        image_crop = $('#image_demo').croppie({
          viewport: {
            width: 200,
            height: 200,
            type:'circle'
          },
          boundary:{
            width: 300,
            height: 300
          }
        });
      }
    });


    /// catching up the cover_image change event and binding the image into my croppie. Then show the modal.
    $('#upload').on('change', function(){
      var reader = new FileReader();
      reader.onload = function (event) {
        image_crop.croppie('bind', {
          url: event.target.result,
        });
      }
      reader.readAsDataURL(this.files[0]);
      $('#uploadimageModal').modal('show');
    });


    $('.crop_image').click(function(event){
      image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $('.loader').fadeIn();
        $.ajax({
          url:"../../assets/php/uploadProfileImage.php",
          type: "POST",
          data:{
            "image": response,
            "employeeID": employeeID
          },
          success:function(data)
          {
            console.log(data);
            $('#upload').val('');
            image_crop.croppie('destroy');
            $('#uploadimageModal').modal('hide');
            obj = jQuery.parseJSON(data);
            if(obj[0].status == "success"){
              $('.loader').fadeOut();
              swal("Success!", "Profile picture updated!", "success")
              .then((value) => {
                $(".profile-user-img").attr("src", "../../assets/profiles/"+obj[0].target+"?"+Date.now());
                $(".sidebarprofilePicture").attr("src", "../../assets/profiles/"+obj[0].target+"?"+Date.now());
              });
            }else {
              $('.loader').fadeOut();
              swal("Error!", "An error occurred, please try again!", "error");
            }
          }
        });
      })
    });

  });


  $(function () {
    $('#tableUserInvoice').DataTable({
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
<?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
