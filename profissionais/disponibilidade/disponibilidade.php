<?php 
    session_start();
    require_once "../../functions/functions.php";
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/profissionais/disponibilidade/style.css">
    <title>Document</title>
</head>
<body>
    <?php CalendarioProfissional(); ?>
</body>
</html>