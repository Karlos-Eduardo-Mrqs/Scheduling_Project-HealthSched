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
    <link rel="stylesheet" href="../../../styles/gerencia/Ajustes/Tabelas/especialidade.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../icons/Admin.png" type="image/x-icon">
    <title>Alterar Especialidade</title>
</head>
<body data-mensagem="<?php echo $_SESSION['mensagem'] ?? ''; ?>" data-cor="<?php echo $_SESSION['mensagem_cor'] ?? ''; ?>">

    <div class="pop">
        <p id="pair"></p>
    </div>
    
    <!-- Área e Especialidade -->
    <div class="form-container">
        <a href="../Ajustar.php" class="btn-exit">Sair</a>
        <h3>Alterar Especialidade</h3>
        
        <!-- Formulário -->
        <form id="form-alterar-especialidade" class="main-form">
            <div class="group">
                <select id="area-select" name="area">
                    <option value="" disabled selected>Escolha uma área</option>
                    <?php $areas = PuxarAreas(); ?>
                </select>
                <label for="area-select">Área Relacionada:</label>
            </div>

            <div class="group">
                <select id="especialidade-select" name="especialidade" disabled>
                    <option value="" disabled selected>Escolha uma especialidade</option>
                </select>
                <label for="especialidade-select">Especialidade:</label>
            </div>

            <button type="button" id="mostrar-edicao-btn" class="btn-primary">Mostrar Edição</button>
        </form>
    </div>

    <div class="form-card" id="especialidade-form">
        <button type="button" class="btn-cancel">Cancelar Edição</button>
        <h3>Editar Especialidade</h3>
        <form action="Especialidade.php" method="post" id="form-dados-especialidade">        
            
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
            
            <button type="submit" name="enviar_especialidade" class="btn-primary">Editar Especialidade</button>
        </form>
    </div>

    <script src="script.js" defer></script>
</body>
</html>


<?php     
    // Lógica para editar a especialidade
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verifica se o botão de envio de especialidade foi pressionado
        if (isset($_POST['enviar_especialidade'])) {
            $novoNomeEspecialidade = $_POST['nova_especialidade'] ?? '';
            $areaId = $_POST['area'] ?? '';
            $especialidadeId = $_POST['especialidade_id'] ?? '';
    
            // Chama a função para modificar a especialidade
            ModificarEspecialidade($especialidadeId, $novoNomeEspecialidade, $areaId);
        }
    }    
    unset($_SESSION['mensagem'],$_SESSION['mensagem_cor']);
?>