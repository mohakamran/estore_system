<?php
$unzip = new ZipArchive;
$out = $unzip->open('dompdf.zip');
if ($out === TRUE) {
$unzip->extractTo(getcwd());
$unzip->close();
echo 'Successfully unzipped';
} else {
echo 'An error occurred';
}
?>