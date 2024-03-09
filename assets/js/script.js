var interval = setInterval(function () {
  if (document.readyState === "complete") {
    stopLoader();
    clearInterval(interval);
  }
}, 100);

$(document).ready(function () {
  $("#username").keypress(function (e) {
    $("#incorrectCredentials").fadeTo(500, 0);
    $("#username").removeClass("is-invalid");
  });

  $("#password").keypress(function (e) {
    $("#incorrectCredentials").fadeTo(500, 0);
  });
});

function stopLoader() {
  $(".loader").fadeOut();
}

function loginFunction() {
  var remember = "";
  if ($("#remember").is(":checked")) remember = "1";
  else remember = "0";

  $.ajax({
    type: "POST",
    url: "../../assets/php/login.php",
    data: {
      Username: $("#username").val(),
      Password: $("#password").val(),
      Remember: remember,
    },
    beforeSend: function () {
      $(".loader").fadeIn();
    },
    success: function (response) {
      if (response.trim() == "admin") {
        window.location.href = "../../pages/dashboard/";
      } else if (response.trim() == "employee") {
        window.location.href = "../../pages/dashboard/";
      } else {
        $("#incorrectCredentials").fadeTo(0, 1);
        $(".loader").fadeOut();
        $("#password").focus();
      }
    },
  });
}

function logout() {
  swal({
    title: "Are you sure?",
    text: "You want to logout!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      window.open("../../assets/php/logout.php", "_self");
    }
  });
}

function employeeRegistrationAdmin() {
  $.ajax({
    type: "POST",
    url: "../../assets/php/employeeRegistrationAdmin.php",
    data: {
      FName: $("#fname").val(),
      LName: $("#lname").val(),
      Contact: $("#contact").val(),
      Email: $("#email").val(),
      EmpType: $("#employeeType").val(),
      Address: $("#address").val(),
    },
    beforeSend: function () {
      $(".loader").fadeIn();
    },
    success: function (response) {
      console.log(response);
      if (response.trim() == "success") {
        $(".loader").fadeOut();
        swal("Success!", "Employee has been registered!", "success").then(
          (value) => {
            location.reload();
          }
        );
      } else if (response.trim() == "email") {
        $("#email").focus();
        $(".loader").fadeOut();
        swal("Error!", "Email ID already registered!", "error");
      } else if (response.trim() == "phone") {
        $(".loader").fadeOut();
        $("#contact").focus();
        swal("Error!", "Phone number already registered!", "error");
      } else {
        $(".loader").fadeOut();
        swal("Error!", "An error occurred, please try again!", "error");
      }
    },
  });
}
