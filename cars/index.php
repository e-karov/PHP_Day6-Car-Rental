<?php
session_start();
require_once '../components/db_connect.php';


if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
$nav_buttons = "";
if (isset($_SESSION['adm'])) {
    $nav_buttons = "
        <div style='display:flex; justify-content:space-around;' >
        <a href='../dashboard.php'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow;'>Dashboard</button></a>
        <a href='create.php'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow;'>Add New Car</button></a>
        <a href='../logout.php?logout'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow; font-style:italic;' >Sign Out</button></a>
        </div>
        ";
} else {
    $nav_buttons = "
        <div style='display:flex; justify-content:space-around;' >
        <a href='../home.php'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow;'>Home</button></a>
        <a href='reservations.php?id=" . $_SESSION['user'] . "'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow;'>My Reservations</button></a>
        <a href='../logout.php?logout'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow; font-style:italic;' >Sign Out</button></a>
        </div>
    ";
}


$sql = "SELECT * FROM car";
$result = mysqli_query($connect, $sql);
$tbody = '';
if (mysqli_num_rows($result)  > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $available = ($row['available'] == 1) ? 'Available' : 'Not available';
        if (isset($_SESSION['adm'])) {
            $table_class = "table-dark";

            $tbody .= "
            <tr>
                <td><img class='img-thumbnail' src='../pictures/" . $row['picture'] . "'</td>
                <td style='text-align:center'>" . $row['make'] . "</td>
                <td style='text-align:center'>" . $row['model'] . "</td>
                <td style='text-align:center'>" . $row['price'] . "</td>
                <td style='text-align:center'>" . $available . "</td>
                <td style='text-align:center'><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
                <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
            </tr>
            ";
        } elseif (isset($_SESSION['user'])) {
            $table_class = "table-light";
            if ($available == "Available") {
                $tbody .= "
            <tr>
                <td><img class='img-thumbnail' src='../pictures/" . $row['picture'] . "'</td>
                <td  style='text-align:center'>" . $row['make'] . "</td>
                <td  style='text-align:center'>" . $row['model'] . "</td>
                <td  style='text-align:center'>" . $row['price'] . "</td>
                <td  style='text-align:center'><a href='booking.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>
                Go to Reservation</button></a>
            </tr>
            ";
            }
        }
    };
} else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <?php require_once '../components/boot.php' ?>
    <style type="text/css">
        .manageProduct {
            margin: auto;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>
    <div class="hero" style="text-align: center;">
        <?= $nav_buttons; ?>
    </div>
    <div class="manageProduct w-75 mt-3">
        <p class='h2'>Cars Available</p>
        <table class='table table-striped <?= $table_class; ?>'>
            <thead class='thead-dark'>
                <tr>
                    <th style="text-align: left;">Picture</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Price per Day</th>
                    <?php
                    if (isset($_SESSION['adm'])) {
                        echo "<th>{$available}</th>";
                    }
                    ?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?= $tbody; ?>
            </tbody>
        </table>
    </div>
</body>

</html>