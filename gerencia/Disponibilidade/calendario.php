
<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    require_once "../../functions/functions.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário Manual</title>
    <link rel="shortcut icon" href="../../icons/Admin.png" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/gerencia/Disponibilidade/style.css">
</head>
<body>
    <?php Calendario();?>
</body>
</html>