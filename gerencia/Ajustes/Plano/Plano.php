<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../../index.php");
        exit();
    }
    require "../../../functions/functions.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/gerencia/Ajustes/Tabelas/plano.css">
    <link rel="shortcut icon" href="../../../icons/Admin.png" type="image/x-icon">    
    <title>Alterar Planos De Saúde</title>
</head>
<body data-mensagem="<?php echo $_SESSION['mensagem'] ?? ''; ?>" data-cor="<?php echo $_SESSION['mensagem_cor'] ?? ''; ?>">
    <div class="pop">
        <p id="pair"></p>                
    </div>        
    
    <div class="popup-del-back">
        <div class="popup-del">
            <p id="message-del"></p>
            <button id="yes">Sim</button>
            <button id="no">Não</button>
        </div>
    </div>

    <div class="form-card" id="AlterarPlanoForm">
        <a href="../Ajustar.php"> Sair </a>
        <h3>Alterar Planos</h3>
        <div id="tabela-planos-container" data-tabela="plano" class="back-tabela">
            <table id="AlterarPlanos" class="tabela">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php listarPlanos(); ?>
                    </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" defer></script>
</body>
</html>