<?php
session_start();
if (isset($_SESSION['userType']) && isset($_GET['folderID'])) {

  $folderID = $_GET['folderID'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v' . $_SESSION['userType'] . '.php';
?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Directory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Directory</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php

    include_once '../../assets/php/connection.php';

    $result = mysqli_query($con, "SELECT * FROM directory WHERE id = '$folderID'")
      or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while ($row = mysqli_fetch_array($result)) {
        $folderName = $row['folderName'];
        $contents = $row['contents'];
    ?>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title"><?= $row['folderName']; ?></h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body">
                    <input type="text" id="folderContents-list" hidden>
                    <input type="file" name="files[]" class="folderContents" id="folderContents" multiple="multiple">
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <?php if ($_SESSION["userType"] == "0") { ?>
                  <button type="button" name="button" class="btn btn-danger float-right" onclick="deleteFolder(<?= $row["id"]; ?>)">DELETE FOLDER</button>
                <?php } ?>
              </div>
              <!--/.col (right) -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    <?php
      }
    }

    ?>

  </div>
  <!-- /.content-wrapper -->




  <?php
  include '../elements/footer.php';

  ?>
  <link href="../../vendor/plugins/filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
  <link href="../../vendor/plugins/filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
  <script src="../../vendor/plugins/filer/js/jquery.filer.js"></script>
  <script type="text/javascript">
    var folderName = '<?= $folderName; ?>';


    $(document).ready(function() {

      $("#navDirectory").addClass("active");

      var contents = [];
      $.ajax({
        url: '../../assets/php/getFolderContents.php',
        type: 'POST',
        data: {
          folderName: '../../assets/uploads/' + folderName + '/'
        },
        success: function(data) {
          console.log(data)
          var fileDetails = [];
          var fileAttachmentNames = [];
          if (data.trim() != "") {
            var contents = JSON.parse(data);
            Object.keys(contents).forEach(function(key) {
              var value = contents[key];
              console.log(value);
              var req = new XMLHttpRequest();
              req.open('HEAD', '../../assets/uploads/' + folderName + '/' + value, false);
              req.send();
              if (req.status == 200) {
                var fileDetail = {
                  name: value,
                  file: '../../assets/uploads/' + folderName + '/' + value,
                  url: '../../assets/uploads/' + folderName + '/' + value
                }
                fileAttachmentNames.push(value)
                fileDetails.push(fileDetail);
              }
            });
          }
          addFiles('folderContents', fileDetails, fileAttachmentNames);
        }
      });

    });


    function deleteFolder(id) {

      var alertText = "";
      var deleteUrl = "";
      deleteUrl = "../../assets/php/removeFolder.php";
      alertText = "The Folder would be deleted permanently!"

      swal({
          title: "Are you sure?",
          text: alertText,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              type: 'POST',
              url: deleteUrl,
              data: {
                folderID: id,
                folderName: folderName
              },
              beforeSend: function() {
                $('.loader').fadeIn();
              },
              success: function(response) {
                console.log(response);
                if (response.trim() == "success") {
                  $('.loader').fadeOut();
                  swal("Success!", "Deletion successful!", "success");
                  window.open('index.php', '_self');
                } else {
                  $('.loader').fadeOut();
                  swal("Error!", "An error occurred, please try again!", "error");
                }
              }
            });
          }
        });
    }

    function addFiles(filerID, fileDetails, fileAttachmentNames) {
      var uploadedFiles = fileAttachmentNames;
      $("#" + filerID).filer({
        limit: null,
        maxSize: null,
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
          beforeSend: function() {},
          success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
            var parent = itemEl.find(".jFiler-jProgressBar").parent(),
              new_file_name = JSON.parse(data),
              filerKit = inputEl.prop("jFiler");
            filerKit.files_list[id].name = new_file_name;
            uploadedFiles.push(new_file_name);
            $("#" + filerID + "-list").val(JSON.stringify(uploadedFiles))
            itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function() {
              $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
            });
          },
          error: function(el) {
            var parent = el.find(".jFiler-jProgressBar").parent();
            el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
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
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
          var filerKit = inputEl.prop("jFiler"),
            file_name = filerKit.files_list[id].name;
          if (file_name == undefined) {
            file_name = filerKit.files_list[id].file.name;
          }
          uploadedFiles = jQuery.grep(uploadedFiles, function(value) {
            return value != file_name;
          });
          $("#" + filerID + "-list").val(JSON.stringify(uploadedFiles))
          $.post('../../vendor/plugins/filer/php/ajax_remove_file.php?folderName=' + folderName, {
            file: file_name
          });
        },
        onEmpty: null,
        options: null,
        dialogs: {
          alert: function(text) {
            return alert(text);
          },
          confirm: function(text, callback) {
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

    function downloadAttachment(fileName) {
      window.open('../../assets/uploads/' + folderName + '/' + fileName.id, '_self');
    }
  </script>
<?php

} else {
?>
  <script>
    window.open('../../', '_self')
  </script>
<?php
}


?>