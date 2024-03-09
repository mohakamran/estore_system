<?php

include '../elements/header.php';

session_start();
if(isset($_SESSION['userType'])){
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
}
include 'changePassword.php';
include '../elements/footer.php';

?>
<!-- jquery-validation -->
<script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
<script type="text/javascript">

$("#navAddEmployee").addClass("active");
//FORM VALIDATION ***************

var attempts = 0;
var otpHash = "";

$(document).ready(function () {

  $('#username').keypress(function(e){
    $("#incorrectCredentials").fadeTo(500, 0);
    $('#username').removeClass('is-invalid');
  });

  $('#email').keypress(function(e){
    $("#incorrectCredentials").fadeTo(500, 0);
    $('#email').removeClass('is-invalid');
  });

  $('#otp').keypress(function(e){
    $("#incorrectCredentials").fadeTo(500, 0);
  });

  $('#newPassword').keypress(function(e){
    $("#incorrectCredentials").fadeTo(500, 0);
  });

  $('#confirmPassword').keypress(function(e){
    $("#incorrectCredentials").fadeTo(500, 0);
  });

  $("#sendOTPButton").on('click', function(){
    $('#signin-form').validate({
      rules: {
        username: {
          required: true
        },
        email: {
          required: true
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    if($('#signin-form').valid()){
      if(otpHash != ""){
        resendOTP();
      }else{
        sendOTP();
      }
    }
  });


  $("#submitButton").on('click', function(){
    $('#signin-form').validate({
      rules: {
        username: {
          required: true
        },
        email: {
          required: true
        },
        otp: {
          required: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    if($('#signin-form').valid()){
      checkOTP();
    }
  });

  $("#changePasswordButton").on('click', function(){
    $('#signin-form').validate({
      rules: {
        newPassword: {
          required: true
        },
        confirmPassword: {
          required: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
    if($('#signin-form').valid()){
      changePassword();
    }
  });

});

function sendOTP(){
  $.ajax({
    type: 'POST',
    url: '../../assets/php/OTPSend.php',
    data: {
      username: $('#username').val(),
      email: $('#email').val(),
      otp: $('#otp').val()
    },
    beforeSend: function() {
      $('.loader').fadeIn();
    },
    success: function(response) {
      console.log(response);
      if(response.trim() == "failed"){
        $('.loader').fadeOut();
        swal("Error!", "An error occurred, please try again!", "error");
      }
      else if (response.trim() == "invalid"){
        $("#incorrectCredentials").html('Invalid username or email!');
        $("#incorrectCredentials").fadeTo(0, 1);
        $('.loader').fadeOut();
        $('#username').focus();
      }else {
        $('.loader').fadeOut();
        swal("OTP Sent!", "Check your email for OTP", "success")
        .then((value) => {
          attempts++;
          $("#sendOTPButton").html("Resend OTP");
          otpHash = response.trim();
          $("#username").prop('disabled', true);
          $("#email").prop('disabled', true);
        });
      }
    }
  });
}

function resendOTP(){
  $.ajax({
    type: 'POST',
    url: '../../assets/php/OTPResend.php',
    data: {
      username: $('#username').val(),
      email: $('#email').val(),
      otp: otpHash
    },
    beforeSend: function() {
      $('.loader').fadeIn();
    },
    success: function(response) {
      console.log(response);
      if(response.trim() == "failed"){
        $('.loader').fadeOut();
        swal("Error!", "An error occurred, please try again!", "error");
      }else {
        $('.loader').fadeOut();
        swal("OTP Resent!", "Check your email for OTP", "success")
        .then((value) => {
          attempts++;
          $("#sendOTPButton").html("Resend OTP");
          otpHash = response.trim();
          $("#username").prop('disabled', true);
          $("#email").prop('disabled', true);
          if(attempts > 2){
            $("#sendOTPButton").remove();
          }
        });
      }
    }
  });
}

function checkOTP(){
  $.ajax({
    type: 'POST',
    url: '../../assets/php/OTPCheck.php',
    data: {
      username: $('#username').val(),
      email: $('#email').val(),
      otp: $('#otp').val()
    },
    beforeSend: function() {
      $('.loader').fadeIn();
    },
    success: function(response) {
      console.log(response);
      if(response.trim() == "failed"){
        $('.loader').fadeOut();
        swal("Error!", "An error occurred, please try again!", "error");
      }else if(response.trim() == "invalid"){
        $('.loader').fadeOut();
        $("#incorrectCredentials").html('Incorrect OTP!');
        $("#incorrectCredentials").fadeTo(0, 1);
        $('.loader').fadeOut();
        $('#otp').focus();
      }else {
        $('.loader').fadeOut();
        $('#otp').prop('disabled', true);
        $("#newPasswordGroup").fadeIn();
        $("#confirmPasswordGroup").fadeIn();
        $("#ButtonSet1").fadeOut();
        $("#ButtonSet2").fadeIn();
      }
    }
  });
}

function changePassword(){
  if($("#newPassword").val() == $("#confirmPassword").val()){
    $.ajax({
      type: 'POST',
      url: '../../assets/php/changePassword.php',
      data: {
        username: $('#username').val(),
        email: $('#email').val(),
        otp: $('#otp').val(),
        password: $('#confirmPassword').val()
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if(response.trim() == "success"){
          $('.loader').fadeOut();
          swal("Success!", "Password changed", "success")
          .then((value) => {
            window.open('../login', '_self');
          });
        }else {
          $('.loader').fadeOut();
          swal("Error!", "An error occurred, please try again!", "error");
        }
      }
    });
  }else{
    $("#incorrectCredentials").html('Password do not match!');
    $("#incorrectCredentials").fadeTo(0, 1);
  }
}

</script>
