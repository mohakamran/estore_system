<?php
session_start();
if(isset($_SESSION['userType']) && $_SESSION['userType'] == '0'){
  ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
  <link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
  <?php

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';


  $expenseID = $_GET['expenseID'];

  include_once '../../assets/php/connection.php';

  $result= mysqli_query($con, "SELECT * FROM expense WHERE id = '$expenseID'")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){
    // output data of each row
    while($row = mysqli_fetch_array($result)) {
      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>View Expense</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Expense</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Expense Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" id="ExpenseFormUpdate">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6  col-sm-12">
                          <div class="form-group">
                            <label for="expenseAmount">Expense Amount (£)</label>
                            <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="Enter expense amount" value="<?=$row['expenseAmount'] ?>" disabled>
                          </div>
                        </div>
                        <div class="col-md-6  col-sm-12">
                          <div class="form-group">
                            <label for="expenseDate">Expense Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="expenseDate" value="<?=$row['expenseDate'] ?>" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="expenseDescription">Expense Description</label>
                            <textarea class="form-control" id="expenseDescription" name="expenseDescription" placeholder="Enter expense description/ notes." rows="3" disabled><?=$row['expenseDescription'] ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="formAttachments" hidden>
                        <label>Attachments</label>
                        <input type="file" name="files[]" id="filer_input" multiple="multiple" disabled>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </form>
                </div>
                <!-- /.card -->
              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php
    }
  }

  include '../elements/footer.php';
  ?>
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
  <script type="text/javascript">

  var fileDetails = [];
  var folderName = "";
  $(document).ready(function(){
    $.ajax({
      type: 'POST',
      url: "../../assets/php/getExpenses.php",
      data: {
        expenseID: <?=$_GET['expenseID'] ?>
      },
      success: function(data) {
        console.log(data)
        obj = jQuery.parseJSON(data);
        if(obj[0].fileNames == null){
          $("#formAttachments").remove();
        }else{
          $("#formAttachments").attr("hidden", false);
          var attachments = obj[0].fileNames.split(",");
          folderName = folderName + obj[0].folderName.toString();
          for(attachment in attachments){
            var fileDetail = {
              name: attachments[attachment],
              file: '../../assets/uploads/' + obj[0].folderName + '/' + attachments[attachment],
              url: '../../assets/uploads/' + obj[0].folderName + '/' + attachments[attachment]
            }
            fileDetails.push(fileDetail);
          }

          $("#filer_input").filer({
            limit: null,
            maxSize: null,
            extensions: null,
            showThumbs: true,
            theme: "dragdropbox",
            files: fileDetails,
            templates: {
              box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
              item: '<li class="jFiler-item">\
              <div class="jFiler-item-container">\
              <div class="jFiler-item-inner">\
              <div class="jFiler-item-thumb">\
              <div class="jFiler-item-status"></div>\
              <div class="jFiler-item-thumb-overlay">\
              <div class="jFiler-item-info">\
              <div style="display:table-cell;vertical-align: middle;">\
              <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
              <span class="jFiler-item-others">{{fi-size2}}</span>\
              </div>\
              </div>\
              </div>\
              {{fi-image}}\
              </div>\
              <div class="jFiler-item-assets jFiler-row">\
              <ul class="list-inline pull-left">\
              <li>{{fi-progressBar}}</li>\
              </ul>\
              <ul class="list-inline pull-right">\
              <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
              </ul>\
              </div>\
              </div>\
              </div>\
              </li>',
              itemAppend: '<li class="jFiler-item">\
              <div class="jFiler-item-container">\
              <div class="jFiler-item-inner">\
              <div class="jFiler-item-thumb">\
              <div class="jFiler-item-status"></div>\
              <div class="jFiler-item-thumb-overlay">\
              <div class="jFiler-item-info">\
              <div style="display:table-cell;vertical-align: middle;">\
              <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
              </div>\
              </div>\
              </div>\
              {{fi-image}}\
              </div>\
              <div class="jFiler-item-assets jFiler-row">\
              <ul class="list-inline pull-right">\
              <li><span class="downloadButton" id="{{fi-name}}" onclick="downloadAttachment(this)" style="color: #4285F4;"><i class="fas fa-2x fa-arrow-circle-down"></i></span></li>\
              </ul>\
              </div>\
              </div>\
              </div>\
              </li>',
              progressBar: '<div class="bar"></div>',
              itemAppendToEnd: false,
              canvasImage: true,
              removeConfirmation: true,
              _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
              }
            },
          });
          $('.jFiler-input-button').remove();
          $(".jFiler-input-caption").remove();
        }
      }
    });
  });

  function downloadAttachment(fileName){
    if (typeof Android === "undefined") {
      window.open('../../assets/uploads/'+folderName+'/'+fileName.id,'_self');
    } else {
      var url = 'https://structalpha.com/projects/microshield/assets/uploads/'+folderName+'/'+fileName.id;
      Android.downloadPDF(url, fileName.id);
    }
  }

</script>
<?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
