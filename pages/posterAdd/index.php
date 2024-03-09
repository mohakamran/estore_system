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
  $empID = $_SESSION['id'];

  include '../elements/header.php';
  include '../elements/navbar.php';
  include '../elements/sidebar-v'.$_SESSION['userType'].'.php';
  include_once '../../assets/php/connection.php';
  include 'addPoster.php';
  include '../elements/footer.php';

  ?>
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/filer/js/jquery.filer.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../vendor/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../vendor/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../vendor/plugins/moment/moment.min.js"></script>
  <script src="../../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

  <script type="text/javascript">


  var propertyTimestamp = '<?php echo time(); ?>';
  var folderName = 'Poster-' + propertyTimestamp;

  $(document).ready(function () {

    $("#navPosterTree").addClass("menu-open");
    $("#navPoster").addClass("active");
    $("#navAddPoster").addClass("active");

    $("#pictureCard1").click();
    $("#pictureCard2").click();

    initFiler('propertyPicturePrimary');
    initFiler('propertyPictureSecondary');
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

    //Addition Form - PNR
    $('#propertyForm').validate({
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
        url: '../../assets/php/posterAddition.php',
        data: {
          timestampID: propertyTimestamp,
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
            swal("Success!", "Poster Added!", "success")
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

  function initFiler(filerID){

    if(filerID == 'propertyPicturePrimary'){
      var uploadedFiles = [];
      $("#"+filerID).filer({
        limit: 1,
        maxSize: 2,
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
      var uploadedFiles = [];
      $("#"+filerID).filer({
        limit: 3,
        maxSize: 2,
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
  </script>

  <?php

}else{
  ?>
  <script>window.open('../../','_self')</script>
  <?php
}


?>
