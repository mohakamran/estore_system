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
  $empID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include_once '../../assets/php/connection.php';
  include 'addExpense.php';
  include '../elements/footer.php';

  ?>
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
  <script type="text/javascript">


  var uploadedFiles = [];
  var folderName = 'Expense-<?php echo time(); ?>';

  $(document).ready(function(){

    //Example 2
    $("#filer_input").filer({
      limit: null,
      maxSize: null,
      extensions: null,
      changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
      showThumbs: true,
      theme: "dragdropbox",
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
        <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
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
      files: null,
      addMore: false,
      allowDuplicates: true,
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
  })


  $(document).ready(function () {

    $("#navExpenseTree").addClass("menu-open");
    $("#navExpense").addClass("active");
    $("#navAddExpense").addClass("active");

    //Addition Form - PNR
    $('#ExpenseForm').validate({
      submitHandler: function () {
        addExpense();
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

  function addExpense(){

    $.ajax({
      type: 'POST',
      url: '../../assets/php/expenseAdd.php',
      data: {
        expenseAmount: $('#expenseAmount').val(),
        expenseDate: moment($('#expenseDate').val()).format('YYYY-MM-DD'),
        expenseDescription: $('#expenseDescription').val(),
        folderName: folderName,
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


  </script>
  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
