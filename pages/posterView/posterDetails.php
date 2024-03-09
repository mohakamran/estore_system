<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';


  $posterID = $_GET['posterID'];

  include_once '../../assets/php/connection.php';

  $result= mysqli_query($con, "SELECT * FROM poster WHERE id = '$posterID'")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){
    // output data of each row
    while($row = mysqli_fetch_array($result)) {

      $posterTimestamp = $row['timestampID'];

      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Poster Details</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Poster</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section><br>

        <!-- Main content -->
        <section class="content" id="print-content">
          <div class="container-fluid">
            <div class="row" style="background-color: #1A237E; color: white;">
              <div class="col-md-4 col-sm-12">
                <div class="row" style="background-color: #FFF; height: 300px;">
                  <div class="col-12" style="display: flex; justify-content: center; align-items:center;">
                    <img src="../../assets/images/logo-min.png" alt="" style="height: 150px;">
                  </div>
                </div>
                <div class="row" style="height:300px;">
                  <div class="col-12">
                    <center>
                      <span style="font-size: 90px;">WEEKLY</span><br>
                      <span style="font-size: 90px; font-weight: bold;">REPORT</span>
                    </center>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-12" style="padding: 0;">
                <img src="../../assets/uploads/Poster-<?=$posterTimestamp.'/'.json_decode($row['primaryImage'])[0]; ?>" class="img-responsive" style="width: 100%; height: 600px;">
              </div>
            </div>
            <div class="row" style="background-color: #1A237E; color: white;">
              <div class="col-md-4 col-sm-12" style=" background-color: #FFF; padding: 50px; color: black;">
                <span style="font-size: 25px; font-weight: bold;">ASIN(s)</span><br><br>
                <?php
                $ASINArray = json_decode($row['ASINArray']);
                $counter = 1;
                foreach ($ASINArray as $ASINValue) {
                  ?>
                  <span style="font-size: 20px;">ASIN <?=$counter; ?> - <?=$ASINValue; ?></span><br>
                  <?php
                  $counter++;
                }
                ?>
              </div>
              <div class="col-md-8 col-sm-12" style=" padding: 4vw 50px;">
                <span style="font-size: 25px; font-weight: bold;">ASIN DETAILS</span><br><br>
                <p style="font-size: 20px;">
                  <?=$row['ASINDetails']; ?>
                </p>
              </div>
            </div>
            <div class="row" style="display: flex; justify-content: center; background-color: #1A237E; color: white;">
              <?php
              $secondaryImages = json_decode($row['secondaryImages']);
              for($index = 0; $index < sizeOf($secondaryImages); $index++){
                ?>
                <div class="col-md-4 col-sm-12" style="padding: 20px;">
                  <img src="../../assets/uploads/Poster-<?=$posterTimestamp.'/'.$secondaryImages[$index]; ?>" alt="" style="position: relative; width: 100%; height: 300px; border-radius: 10px !important;" class="img-responsive">
                </div>
                <?php
              }
              ?>
            </div>
            <div class="row" style="background-color: #1A237E; color: white; padding-top: 50px;">
              <div class="col-md-6 col-sm-12">
                <center>
                  <span style="font-size: 40px; font-weight: bold;">ENQUIRE: +44 20 3500 3475</span>
                </center>
              </div>
              <div class="col-md-6 col-sm-12" style="margin-top: 20px;">
                <span style="font-size: 20px;">info@estoresexperts.com | www.estoresexperts.com</span>
              </div>
            </div>
            <div class="row" style="background-color: #1A237E; color: white; font-size: 10px; padding: 20px 50px;">
              <div class="col-12">
                <p>
                  Note: The information contained in these particulars are for general information purposes only. Global Wide Services LTD T/A E-stores Experts, address F3, 298 Romford Road, London E7 9HD doesn’t provide information other than the selling account. Images attached to this report are real time images taken from the selling account reports.
                </p>
              </div>
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section><br><br>
        <center>
          <button type="button" name="button" onclick="printDiv('print-content')" class="btn btn-primary">PRINT POSTER</button>
        </center>
        <br><br><br>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php
    }
  }

  include '../elements/footer.php';
  ?>
  <script>

  $("#navPosterTree").addClass("menu-open");
  $("#navPoster").addClass("active");
  $("#navViewPoster").addClass("active");

  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
  }

  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
