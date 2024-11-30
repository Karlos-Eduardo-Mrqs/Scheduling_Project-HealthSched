<?php 
    require "../../functions/functions.php";

    if (isset($_POST['enviar_plano'])) {
        if (!empty($_POST['novo_plano'])) {
            CriarPlano($_POST['novo_plano']);
        }
    }
    
    if (isset($_POST['enviar_area'])) {
        if (!empty($_POST['nova_area'])) {
            CriarArea($_POST['nova_area']);
        }
    }

    if (isset($_POST['enviar_especialidade'])) {
        if (!empty($_POST['nova_especialidade'])) {
            var_dump($_POST);
            AdicionarEspecialidade($_POST['nova_especialidade'],$_POST['area']);
        }
    }
    
?>