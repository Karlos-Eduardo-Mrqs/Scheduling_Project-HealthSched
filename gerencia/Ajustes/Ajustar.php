<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    require "../../functions/functions.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes</title>
    <link rel="shortcut icon" href="../../icons/Admin.png" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/gerencia/Ajustes/style.css">
</head>

<?php require "../SideBar/SideBar.php"; ?>

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

            <div class="menu-container">
                <div class="menu card">
                    <h2 id="add">Adicionar Itens</h2>
                    <ul>
                        <li><button id="AbrirPlano">Adicionar Plano</button></li>
                        <li><button id="AbrirEspecialidade">Adicionar Especialidade</button></li>
                        <li><button id="AbrirArea">Adicionar Área</button></li>
                    </ul>
                </div>
                <div class="menu card">
                    <h2 id="alter">Alterar Itens</h2>
                    <ul>
                        <li><button><a href="./Plano/Plano.php" id="AbrirPlanoAlterar">Alterar Plano</a></button></li>
                        <li><button><a href="./Especialidade/Especialidade.php" id="AbrirEspecialidadeAlterar">Alterar Especialidade</a></button></li>
                        <li><button><a href="./Area/Area.php" id="AbrirAreaAlterar">Alterar Área</a></button></li>
                    </ul>
                </div>
            </div>
    
    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="close" class="close">&times;</span>
            
            <div class="form-card" id="PlanoForm">
                <h3>Adicionar Plano</h3>
                <form action="Enviar.php" method="post">
                    <div class="group">
                        <input type="text" name="novo_plano" id="novo_plano" maxlength="30" required placeholder=" ">
                        <label for="novo_plano">Novo Plano</label>
                    </div>
                    <button type="submit" name="enviar_plano"> Criar Plano </button>
                </form>
            </div>

            <div class="form-card" id="EspecialidadeForm">
                <h3>Adicionar Especialidade</h3>
                <form action="Enviar.php" method="post">
                    <div class="group">
                        <input type="text" name="nova_especialidade" id="nova_especialidade" maxlength="30" required placeholder=" ">
                        <label for="nova_especialidade">Nova Especialidade</label>
                    </div>
                    <div class="group">
                        <select name="area" id="area" required>
                            <option disabled selected>Selecione A Área De Saúde</option>
                            <?php PuxarAreas(); ?>
                        </select>
                        <label for="area">Relacione À Com A Área</label>
                    </div>
                    <button type="submit" name="enviar_especialidade"> Criar Especialidade </button>
                </form>
            </div>

            <div class="form-card" id="AreaForm">
                <h3>Adicionar Área</h3>
                <form action="Enviar.php" method="post">        
                    <div class="group">
                        <input type="text" name="nova_area" id="nova_area" maxlength="30" required placeholder=" ">
                        <label for="nova_area">Nova Área</label>
                    </div>
                    <button type="submit" name="enviar_area"> Criar Área </button>
                </form>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script src="script.js"></script>
</body>
<?php unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']); ?>
</html>
