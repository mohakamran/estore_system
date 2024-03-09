<?php
$unzip = new ZipArchive;
$out = $unzip->open('EStoresExperts.zip');
if ($out === TRUE) {
$unzip->extractTo(getcwd());
$unzip->close();
echo 'Successfully unzipped';
} else {
echo 'An error occurred';
}
?>