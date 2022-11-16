<?php
session_start();

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../components/db_connect.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM car WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $make = $data['make'];
        $price = $data['price'];
        $picture = $data['picture'];
        $model = $data['model'];
        $available = ($data['available'] == 1) ? "Available" : "Not available";
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Make Reservation</title>
    <?php require_once '../components/boot.php' ?>
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>

<body>
    <fieldset>
        <legend class='h2'>Booking Request <img class='img-thumbnail rounded-circle' src='../pictures/<?php echo $picture ?>' alt="<?php echo "{$make} {$model}" ?>"></legend>
        <form action="actions/a_booking.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Make</th>
                    <td><input class="form-control" type="text" name="make" value="<?php echo $make ?>" /></td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td><input class="form-control" type="text" name="model" value="<?php echo $model ?>" /></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><input class="form-control" type="number" name="price" step="any" disabled value="<?php echo $price ?>" /></td>
                </tr>
                <tr>
                    <th>Date from:</th>
                    <td><input class="form-control" type="date" name="fromDate" required /></td>
                </tr>
                <tr>
                    <th>Date to:</th>
                    <td><input class="form-control" type="date" name="toDate" required /></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>" />
                    <td><button class="btn btn-success" type="submit">Confirm Booking</button></td>
                    <td><a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>

</html>