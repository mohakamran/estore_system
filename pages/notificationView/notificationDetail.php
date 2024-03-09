<?php
session_start();
if(isset($_SESSION['userType'])){


  include '../elements/header.php';

  ?>

  <link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
  <link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

  <?php

  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notification</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Notification</li>
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
                <h3 class="card-title">Notification Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="form-group">
                  <label for="notificationTitle">Notification Title</label>
                  <input type="text" class="form-control" id="notificationTitle" name="notificationTitle" value="" disabled>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Notification Description</label>
                  <textarea class="form-control" rows="3" id="notificationDescription" name="notificationDescription" disabled></textarea>
                </div>
                <!-- attachments -->
                <div class="form-group" id="formAttachments" hidden>
                  <label>Attachments</label>
                  <input type="file" name="files[]" id="filer_input" multiple="multiple" disabled>
                </div>
              </div>
              <!-- /.card-body -->
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

  include '../elements/footer.php';

  ?>
  <script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
  <script type="text/javascript">

  $("#navNotificationTree").addClass("menu-open");
  $("#navNotification").addClass("active");
  $("#navNotificationView").addClass("active");

  var fileDetails = [];
  var folderName = "";
  $(document).ready(function(){
    $.ajax({
      type: 'POST',
      url: "../../assets/php/getNotifications.php",
      data: {
        notificationID: <?=$_GET['notification'] ?>
      },
      success: function(data) {
        obj = jQuery.parseJSON(data);
        $("#notificationTitle").val(obj[0].title);
        $("#notificationDescription").text(obj[0].description);
        folderName = folderName + obj[0].folderName.toString();
        if(obj[0].fileNames == null){
          $("#formAttachments").remove();
        }else{
          $("#formAttachments").attr("hidden", false);
          var attachments = obj[0].fileNames.split(",");

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
              <li><span class="downloadButton" id="{{fi-name}}" onclick="downloadAttachment(this)" ><i class="fas fa-2x fa-arrow-circle-down"></i></span></li>\
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

<style media="screen">
.jFiler-item{
  cursor: pointer;
}
.downloadButton{
  color: #4285F4;
}
</style>
<?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
