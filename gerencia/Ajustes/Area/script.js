document.addEventListener("DOMContentLoaded", function() {
    // Função para manipular a edição da área
    document.querySelectorAll(".edit-area").forEach(function(editButton) {
        editButton.addEventListener("click", function(event) {
            const areaId = event.target.getAttribute("data-id");
            editarArea(areaId);
        });
    });

    // Função para manipular a exclusão da área
    document.querySelectorAll(".delete-area").forEach(function(deleteButton) {
        deleteButton.addEventListener("click", function(event) {
            const areaId = event.target.getAttribute("data-id");
            const areaNome = event.target.getAttribute("data-name");
            confirmarExclusao(areaId, areaNome);
        });
    });
});

// Função para exibir mensagens no pop-up
function exibirPopup(mensagem, sucesso = true) {
    const popUp = document.querySelector(".pop");
    const pair = document.getElementById("pair");
    
    pair.style.color = sucesso ? "#4CAF50" : "#f44336";
    pair.textContent = mensagem;

    popUp.style.display = "block";

    setTimeout(() => {
        popUp.style.display = "none";
    }, 3000);
}

// Função para editar a área
function editarArea(areaId) {
    const areaRow = document.querySelector(`#area-${areaId}`);
    
    if (!areaRow) {
        console.error(`Área com ID ${areaId} não encontrada.`);
        return;
    }

    const areaNomeCell = areaRow.querySelector(`.nome-area`);
    const areaNomeDisplay = areaNomeCell.querySelector('.area-nome-display');
    const areaNomeInput = areaNomeCell.querySelector('.area-nome-input');

    if (!areaNomeDisplay || !areaNomeInput) {
        console.error('Elementos de nome da área não encontrados.');
        return;
    }

    areaNomeDisplay.style.display = 'none';
    areaNomeInput.style.display = 'block';
    areaNomeInput.value = areaNomeDisplay.textContent.trim();
    areaNomeInput.focus();
    
    areaNomeInput.onblur = () => salvarEdicao(areaId, areaNomeInput.value, areaNomeDisplay, areaNomeInput);
    areaNomeInput.onkeypress = (event) => {
        if (event.key === 'Enter') {
            salvarEdicao(areaId, areaNomeInput.value, areaNomeDisplay, areaNomeInput);
        }
    };
}

// Função para salvar a edição da área
// Função para salvar a edição da área
function salvarEdicao(areaId, novoNome, areaNomeDisplay, areaNomeInput) {
    if (novoNome.trim() !== "") {
        fetch("editar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: areaId, nome: novoNome.trim() })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao salvar dados');
            }
            return response.json(); // Retorna a resposta como JSON
        })
        .then(data => {
            if (data.sucesso) {
                areaNomeDisplay.textContent = novoNome.trim(); // Atualiza a exibição do nome
                exibirPopup('Área atualizada com sucesso!', true);
            } else {
                exibirPopup('Erro ao salvar dados', false);
            }
        })
        .catch(error => {
            console.error('Erro ao salvar os dados', error);
            exibirPopup('Erro de conexão ao atualizar.', false);
        });
    } else {
        exibirPopup('Nome da área não pode ser vazio.', false);
    }

    // Restaura o estado da exibição do nome
    areaNomeDisplay.style.display = 'block';
    areaNomeInput.style.display = 'none';
}


// Função para confirmar exclusão da área
function confirmarExclusao(areaId, areaNome) {
    const messageDel = document.getElementById("message-del");
    messageDel.textContent = `Tem certeza que deseja excluir a área: ${areaNome}?`;

    const popupDelBack = document.querySelector(".popup-del-back");
    popupDelBack.style.display = "block";

    document.getElementById("yes").onclick = function() {
        excluirArea(areaId);
        popupDelBack.style.display = "none";
    };

    document.getElementById("no").onclick = function() {
        popupDelBack.style.display = "none";
    };
}

// Função para excluir área
function excluirArea(areaId) {
    fetch("deletar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: areaId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            const areaRow = document.querySelector(`#area-${areaId}`);
            areaRow.remove();
            exibirPopup('Área excluída com sucesso!', true);
        } else {
            exibirPopup('Erro ao excluir área.', false);
        }
    })
    .catch(error => {
        console.error('Erro ao excluir área', error);
        exibirPopup('Erro de conexão ao excluir.', false);
    });
}