<?php
session_start();
if(isset($_SESSION['userType'])){
  ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="../../vendor/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../../vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
  <link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
  <?php

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

      $picturesPrimary = $row['primaryImage'];
      $picturesSecondary = $row['secondaryImages'];
      $posterTimestamp = $row['timestampID'];

      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Edit Poster</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Poster</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <form role="form" id="posterForm">
              <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Property Details</h3>
                      <div class="card-tools" style="position: relative; top: 10px;">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="row asin-container">
                        <?php

                        $ASINArray = json_decode($row['ASINArray']);
                        $counter = 1;
                        foreach ($ASINArray as $ASINValue) {
                          ?>
                          <div class="col-md-12 asin-input">
                            <div class="form-group">
                              <label>ASIN <?=$counter; ?></label>
                              <input type="text" name="asin" value="<?=$ASINValue; ?>" class="form-control">
                            </div>
                          </div>
                          <?php
                          $counter++;
                        }

                        ?>

                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <button type="button" name="button" class="btn btn-primary add-asin">ADD</button>
                          <button type="button" name="button" class="btn btn-danger remove-asin">REMOVE</button>
                          <br><br>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>ASIN Details</label>
                            <textarea name="ASINDetails" rows="5" id="ASINDetails" class="form-control"><?=$row['ASINDetails']; ?></textarea>
                          </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->


                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Property Picture (Primary)</h3>
                      <div class="card-tools" style="position: relative; top: 10px;">
                        <button id="pictureCard1" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="text" id="propertyPicturePrimary-list" hidden>
                            <input type="file" name="files[]" class="propertyPicturePrimary" id="propertyPicturePrimary" multiple="false">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Property Pictures (Secondary)</h3>
                      <div class="card-tools" style="position: relative; top: 10px;">
                        <button id="pictureCard2" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="text" id="propertyPictureSecondary-list" hidden>
                            <input type="file" name="files[]" class="propertyPictureSecondary" id="propertyPictureSecondary" multiple="multiple">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div><br>
                  <!-- /.card -->


                  <button type="submit" class="btn btn-primary float-right">Update Poster</button>

                </div>
                <!--/.col (right) -->
              </div>
              <!-- /.row -->
            </form>
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
  <script src="../../vendor/plugins/filer/js/jquery.filer.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script type="text/javascript">

  var posterID = '<?=$posterID; ?>';
  var posterTimestamp = '<?=$posterTimestamp; ?>';
  var folderName = 'Poster-' + posterTimestamp;
  var primaryImages = JSON.parse('<?=$picturesPrimary; ?>');
  var secondaryImages = JSON.parse('<?=$picturesSecondary; ?>');

  $(document).ready(function () {

    $("#navPosterTree").addClass("menu-open");
    $("#navPoster").addClass("active");
    $("#navViewPoster").addClass("active");

    $("#propertyPicturePrimary-list").val(JSON.stringify(primaryImages));
    $("#propertyPictureSecondary-list").val(JSON.stringify(secondaryImages));

    check_asin_count();


    $(".add-asin").on("click", function(){
      var asin_count = $(".asin-container").find(".asin-input").length;
      $(".asin-container").append('<div class="col-md-12 asin-input"><div class="form-group"><label>ASIN '+(asin_count+1)+'</label><input type="text" name="asin" value="" class="form-control"></div></div>');
      check_asin_count();
    });

    $(".remove-asin").on("click", function(){
      var asin_count = $(".asin-container").find(".asin-input").length;
      $(".asin-container").find(".asin-input")[asin_count-1].remove();
      check_asin_count();
    });

    var fileDetails = [];
    var fileAttachmentNames = [];
    for(af in primaryImages){
      var req = new XMLHttpRequest();
      req.open('HEAD', '../../assets/uploads/' + folderName + '/' + primaryImages[af], false);
      req.send();
      if(req.status==200){
        var fileDetail = {
          name: primaryImages[af],
          file: '../../assets/uploads/' + folderName + '/' + primaryImages[af],
          type: 'image/*',
          url: '../../assets/uploads/' + folderName + '/' + primaryImages[af]
        }
        fileAttachmentNames.push(primaryImages[af])
        fileDetails.push(fileDetail);
      }
    }
    addFiles('propertyPicturePrimary', fileDetails, fileAttachmentNames);

    fileDetails = [];
    fileAttachmentNames = [];
    for(af in secondaryImages){
      var req = new XMLHttpRequest();
      req.open('HEAD', '../../assets/uploads/' + folderName + '/' + secondaryImages[af], false);
      req.send();
      if(req.status==200){
        var fileDetail = {
          name: secondaryImages[af],
          file: '../../assets/uploads/' + folderName + '/' + secondaryImages[af],
          type: 'image/*',
          url: '../../assets/uploads/' + folderName + '/' + secondaryImages[af]
        }
        fileAttachmentNames.push(secondaryImages[af])
        fileDetails.push(fileDetail);
      }
    }
    addFiles('propertyPictureSecondary', fileDetails, fileAttachmentNames);

    //Addition Form - PNR
    $('#posterForm').validate({
      submitHandler: function () {
        propertyAddition();
      },
      rules: {
        asin: {
          required: true
        },
        ASINDetails: {
          required: true
        },
        files1: {
          required: true
        },
        files2: {
          required: true
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

  function check_asin_count(){
    var asin_count = $(".asin-container").find(".asin-input").length;
    if(asin_count > 1){
      $(".remove-asin").fadeIn(0);
    }else{
      $(".remove-asin").fadeOut(0);
    }
  }

  function propertyAddition(){

    var ASINArray = [];
    var ASINContainerArray = $(".asin-container").find(".asin-input input").each(function(index, element){
      if(element.value.trim() != ""){
        ASINArray.push(element.value)
      }
    });

    if($('#propertyPictureSecondary-list').val() == "" ||JSON.parse($('#propertyPictureSecondary-list').val()).length < 3){
      alert("Minimum 3 secondary images are required!")
    }else if($('#propertyPicturePrimary-list').val() == ""){
      alert("Primary property image is required!")
    }else{
      $.ajax({
        type: 'POST',
        url: '../../assets/php/posterUpdate.php',
        data: {
          timestampID: posterTimestamp,
          ASINArray: JSON.stringify(ASINArray),
          ASINDetails: $('#ASINDetails').val(),
          primaryImage: JSON.stringify(JSON.parse($('#propertyPicturePrimary-list').val())),
          secondaryImages: JSON.stringify(JSON.parse($('#propertyPictureSecondary-list').val())),
        },
        beforeSend: function() {
          $('.loader').fadeIn();
        },
        success: function(response) {
          console.log(response);
          if ( response.trim() == "success" ){
            $('.loader').fadeOut();
            swal("Success!", "Poster Updated!", "success")
            .then((value) => {
              location.reload();
            });
          }else{
            $('.loader').fadeOut();
            swal("Error!", "An error occurred, please try again!", "error");
          }
        }
      });
    }
  }

  function addFiles(filerID, fileDetails, fileAttachmentNames){
    var uploadedFiles = fileAttachmentNames;
    if(filerID == 'propertyPicturePrimary'){
      $("#"+filerID).filer({
        limit: 1,
        maxSize: 2,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
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
          <span class="jFiler-item-others">{{fi-size2}}</span>\
          </div>\
          </div>\
          </div>\
          {{fi-image}}\
          </div>\
          <div class="jFiler-item-assets jFiler-row">\
          <ul class="list-inline pull-left">\
          <li><span class="downloadButton" id="{{fi-name}}" onclick="downloadAttachment(this)" style="color: #4285F4;"><i class="fas fa-2x fa-arrow-circle-down"></i></span></li>\
          </ul>\
          <ul class="list-inline pull-right">\
          <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
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
        dragDrop: {
          dragEnter: null,
          dragLeave: null,
          drop: null,
          dragContainer: null,
        },
        uploadFile: {
          url: "../../vendor/plugins/filer/php/ajax_upload_file.php",
          data: {
            folderName: folderName,
          },
          type: 'POST',
          enctype: 'multipart/form-data',
          synchron: true,
          beforeSend: function(){},
          success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id){
            var parent = itemEl.find(".jFiler-jProgressBar").parent(),
            new_file_name = JSON.parse(data),
            filerKit = inputEl.prop("jFiler");
            filerKit.files_list[id].name = new_file_name;
            uploadedFiles.push(new_file_name);
            $("#"+filerID+"-list").val(JSON.stringify(uploadedFiles))
            itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function(){
              $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
            });
          },
          error: function(el){
            var parent = el.find(".jFiler-jProgressBar").parent();
            el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
              $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
            });
          },
          statusCode: null,
          onProgress: null,
          onComplete: null
        },
        allowDuplicates: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
          var filerKit = inputEl.prop("jFiler"),
          file_name = filerKit.files_list[id].name;
          if(file_name == undefined){
            file_name = filerKit.files_list[id].file.name;
          }
          uploadedFiles = jQuery.grep(uploadedFiles, function(value) {
            return value != file_name;
          });
          $("#"+filerID+"-list").val(JSON.stringify(uploadedFiles))
          $.post('../../vendor/plugins/filer/php/ajax_remove_file.php?folderName='+folderName, {file: file_name});
        },
        onEmpty: null,
        options: null,
        dialogs: {
          alert: function(text) {
            return alert(text);
          },
          confirm: function (text, callback) {
            confirm(text) ? callback() : null;
          }
        },
        captions: {
          button: "Choose Files",
          feedback: "Choose files To Upload",
          feedback2: "files were chosen",
          drop: "Drop file here to Upload",
          removeConfirmation: "Are you sure you want to remove this file?",
          errors: {
            filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
            filesType: "Only Images are allowed to be uploaded.",
            filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
            filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
          }
        }
      });
    }else{
      $("#"+filerID).filer({
        limit: 3,
        maxSize: 2,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
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
          <span class="jFiler-item-others">{{fi-size2}}</span>\
          </div>\
          </div>\
          </div>\
          {{fi-image}}\
          </div>\
          <div class="jFiler-item-assets jFiler-row">\
          <ul class="list-inline pull-left">\
          <li><span class="downloadButton" id="{{fi-name}}" onclick="downloadAttachment(this)" style="color: #4285F4;"><i class="fas fa-2x fa-arrow-circle-down"></i></span></li>\
          </ul>\
          <ul class="list-inline pull-right">\
          <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
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
        dragDrop: {
          dragEnter: null,
          dragLeave: null,
          drop: null,
          dragContainer: null,
        },
        uploadFile: {
          url: "../../vendor/plugins/filer/php/ajax_upload_file.php",
          data: {
            folderName: folderName,
          },
          type: 'POST',
          enctype: 'multipart/form-data',
          synchron: true,
          beforeSend: function(){},
          success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id){
            var parent = itemEl.find(".jFiler-jProgressBar").parent(),
            new_file_name = JSON.parse(data),
            filerKit = inputEl.prop("jFiler");
            filerKit.files_list[id].name = new_file_name;
            uploadedFiles.push(new_file_name);
            $("#"+filerID+"-list").val(JSON.stringify(uploadedFiles))
            itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function(){
              $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
            });
          },
          error: function(el){
            var parent = el.find(".jFiler-jProgressBar").parent();
            el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
              $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
            });
          },
          statusCode: null,
          onProgress: null,
          onComplete: null
        },
        allowDuplicates: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
          var filerKit = inputEl.prop("jFiler"),
          file_name = filerKit.files_list[id].name;
          if(file_name == undefined){
            file_name = filerKit.files_list[id].file.name;
          }
          uploadedFiles = jQuery.grep(uploadedFiles, function(value) {
            return value != file_name;
          });
          $("#"+filerID+"-list").val(JSON.stringify(uploadedFiles))
          $.post('../../vendor/plugins/filer/php/ajax_remove_file.php?folderName='+folderName, {file: file_name});
        },
        onEmpty: null,
        options: null,
        dialogs: {
          alert: function(text) {
            return alert(text);
          },
          confirm: function (text, callback) {
            confirm(text) ? callback() : null;
          }
        },
        captions: {
          button: "Choose Files",
          feedback: "Choose files To Upload",
          feedback2: "files were chosen",
          drop: "Drop file here to Upload",
          removeConfirmation: "Are you sure you want to remove this file?",
          errors: {
            filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
            filesType: "Only Images are allowed to be uploaded.",
            filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
            filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
          }
        }
      });
    }
  }

  function downloadAttachment(fileName){
    window.open('../../assets/uploads/'+folderName+'/'+fileName.id,'_self');
  }

  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
