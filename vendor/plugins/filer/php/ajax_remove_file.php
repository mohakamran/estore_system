<?php
if(isset($_POST['file'])){
    $file = '../../../../assets/uploads/'.$_GET['folderName'].'/' . $_POST['file'];
    if(file_exists($file)){
        unlink($file);
    }
}
?>
