<?php
session_start();
if ($_SESSION['username'] != '') {

    $reportID = $_POST['reportID'];

    include_once 'connection.php';

    $sql = "DELETE FROM reports WHERE id = '$reportID'";
    if ($con->query($sql)) {
        $sql = "DELETE FROM reportdata WHERE reportRefId = '$reportID'";
        $con->query($sql);
        echo "success";
    } else {
        echo mysqli_error($con);
    }
} else {
?>
    <script>
        window.open('../php/logout.php', '_self')
    </script>
<?php
}
?>