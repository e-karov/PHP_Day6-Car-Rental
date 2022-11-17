<?php
session_start();

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST) {
    $user_id = $_SESSION['user'];
    $car_id = $_POST['id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $from_date = $_POST['fromDate'];
    $to_date = $_POST['toDate'];

    $sql = "INSERT INTO booking (fk_user_id, fk_car_id, from_date, to_date) 
                 VALUES ('$user_id', '$car_id', '$from_date', '$to_date')";

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "Your Reservation is confirmed:<br>
            <table class='table w-50'>
                <tr> 
                    <td> $make $model </td> 
                </tr> 
                <tr> <td>Starting from: $from_date To: $to_date </td> </tr>

            </table><hr>";
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book a Car</title>
    <?php require_once '../../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../index.php'><button class="btn btn-primary" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>