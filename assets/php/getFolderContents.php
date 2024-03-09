<?php

if (isset($_POST["folderName"])) {
    $files = array_diff(scandir($_POST["folderName"]), array('.', '..'));
    echo json_encode($files);
}
