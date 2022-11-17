<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}


require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';


if ($_POST) {
    $id = $_POST['id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $available = $_POST['available'];

    //variable for upload pictures errors is initialised
    $uploadError = '';

    $picture = file_upload($_FILES['picture'], 'car');
    if ($picture->error === 0) {
        ($_POST["picture"] == "car.png") ?: unlink("../../pictures/$_POST[picture]");
        $sql = "UPDATE car SET make = '$make', price = $price, picture = '$picture->fileName', available = '$available' WHERE id = {$id}";
    } else {
        $sql = "UPDATE car SET make = '$make', price = $price, available = '$available' WHERE id = {$id}";
    }
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <title>Update</title>
    <?php require_once '../../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../update.php?id=<?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
            <a href='../../dashboard.php'><button class="btn btn-success" type='button'>Dashboard</button></a>
        </div>
    </div>
</body>

</html>