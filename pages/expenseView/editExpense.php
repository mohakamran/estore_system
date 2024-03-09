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
                <h1>Edit Expense</h1>
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
                            <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="Enter expense amount" value="<?=$row['expenseAmount'] ?>">
                          </div>
                        </div>
                        <div class="col-md-6  col-sm-12">
                          <div class="form-group">
                            <label for="expenseDate">Expense Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="expenseDate" value="<?=$row['expenseDate'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="expenseDescription">Expense Description</label>
                            <textarea class="form-control" id="expenseDescription" name="expenseDescription" placeholder="Enter expense description/ notes." rows="3"><?=$row['expenseDescription'] ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Attachments</label>
                        <input type="file" name="files[]" id="filer_input" multiple="multiple">
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary float-right">Update</button>
                    </div>
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
  var uploadedFiles = [];

  $(document).ready(function(){

    $("#navExpenseTree").addClass("menu-open");
    $("#navExpense").addClass("active");
    $("#navViewExpense").addClass("active");

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
          folderName = folderName + obj[0].folderName.toString();
          if(obj[0].fileNames != null && obj[0].fileNames != ""){
            var attachments = obj[0].fileNames.split(",");
            for(attachment in attachments){
              var req = new XMLHttpRequest();
              req.open('HEAD', '../../assets/uploads/' + obj[0].folderName + '/' + attachments[attachment], false);
              req.send();
              if(req.status==200){
                uploadedFiles.push(attachments[attachment]);
                var fileDetail = {
                  name: attachments[attachment],
                  file: '../../assets/uploads/' + obj[0].folderName + '/' + attachments[attachment],
                  url: '../../assets/uploads/' + obj[0].folderName + '/' + attachments[attachment]
                }
                fileDetails.push(fileDetail);
              }
            }
          }


          $("#filer_input").filer({
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
              beforeSend: function(){},
              success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id){
                var parent = itemEl.find(".jFiler-jProgressBar").parent(),
                new_file_name = JSON.parse(data),
                filerKit = inputEl.prop("jFiler");

                filerKit.files_list[id].name = new_file_name;

                uploadedFiles.push(new_file_name);

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

          $('.jFiler-input-button').remove();
          $(".jFiler-input-caption").remove();
        }
      }
    });

    //Registration Form - Customer
    $('#ExpenseFormUpdate').validate({
      submitHandler: function () {
        expenseUpdate();
      },
      rules: {
        expenseAmount: {
          required: true
        },
        expenseDate: {
          required: true
        },
        expenseDescription: {
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

  function expenseUpdate(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/expenseUpdate.php',
      data: {
        expenseID: <?=$_GET['expenseID'] ?>,
        expenseAmount: $('#expenseAmount').val(),
        expenseDate: moment($('#expenseDate').val()).format('YYYY-MM-DD'),
        expenseDescription: $('#expenseDescription').val(),
        fileNames: uploadedFiles.join()
      },
      beforeSend: function() {
        $('.loader').fadeIn();
      },
      success: function(response) {
        console.log(response);
        if ( response.trim() == "success" ){
          $('.loader').fadeOut();
          swal("Success!", "Expense Added!", "success")
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
