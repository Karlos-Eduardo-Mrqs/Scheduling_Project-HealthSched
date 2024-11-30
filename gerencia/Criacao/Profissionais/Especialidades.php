<?php
    require "../../../functions/functions.php";
    if (isset($_POST['area'])) {
        $areaId = $_POST['area']; // Pegue o valor da área
        // Aqui você deve ter uma função que busca especialidades baseadas na área
        $especialidades = PuxarEspecialidades($areaId); // Ajuste isso conforme sua função
        if ($especialidades) {
            echo json_encode($especialidades); // Retorna o JSON das especialidades
        } else {
            echo json_encode(['error' => 'Nenhuma especialidade encontrada.']);
        }
    } else {
        echo json_encode(['error' => 'Área não especificada.']);
    }    
    
?>