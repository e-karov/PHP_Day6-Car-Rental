<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// select logged-in users details - procedural style
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $row['first_name']; ?></title>
    <?php require_once 'components/boot.php' ?>
    <style>
        .userImage {
            width: 200px;
            height: 200px;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="hero" style="text-align: center;">
            <img class="userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
            <p class="text-white">Hi <?php echo $row['first_name'] . '!'; ?></p>
            <div style="display:flex; justify-content:space-around; ">
                <a href='cars/reservations.php?id="<?= $_SESSION['user']; ?>"'><button class='btn btn-outline-secondary' style='margin:3px; color:yellow;'>My Reservations</button></a>
                <a href="cars/index.php"><button class="btn btn-outline-secondary" style="margin:3px; color:yellow;">New Reservation</button></a>
                <a href="update.php?id=<?php echo $_SESSION['user'] ?>">
                    <button class="btn btn-outline-secondary" style="margin: 3px; color: yellow;">Update your profile</button>
                </a>
                <a href="logout.php?logout"><button class="btn btn-outline-secondary" style="margin:3px; color:yellow; font-style:italic; ">Sign Out</button></a>
            </div>
        </div>
    </div>
</body>

</html>