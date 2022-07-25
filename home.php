<?php
require_once './php/config.php';
session_name('JCN');
session_start();
if (!isset($_SESSION['user'])){
     //Nos sabiamos la url pero no pasado login
     header("Location:{$site}index.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MiSitio</title>
</head>
<body>
    <h1>Home - MiSitio</h1>
    <p>Hola <?php echo $_SESSION['user']; ?></p>
</body>
</html>