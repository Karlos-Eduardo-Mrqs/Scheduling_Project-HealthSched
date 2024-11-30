document.addEventListener("DOMContentLoaded", function() {
    // Função para manipular a edição do plano
    document.querySelectorAll("[class^='edit-plan-']").forEach(function(editButton) {
        editButton.addEventListener("click", function(event) {
            const planoId = event.target.getAttribute("data-id");
            editarPlano(planoId);
        });
    });

    // Função para manipular a exclusão do plano
    document.querySelectorAll("[class^='delete-plan-']").forEach(function(deleteButton) {
        deleteButton.addEventListener("click", function(event) {
            const planoId = event.target.getAttribute("data-id");
            const planoNome = event.target.getAttribute("data-name");
            confirmarExclusao(planoId, planoNome);
        });
    });
});

// Função para mostrar mensagens usando a div pop-up
function exibirPopup(mensagem, sucesso = true) {
    const popUp = document.querySelector(".pop");
    const pair = document.getElementById("pair");
    
    // Define a classe com base no sucesso ou falha
    pair.style.color = sucesso ? "#4CAF50" : "#f44336"; // Verde para sucesso, vermelho para erro

    // Exibe a mensagem
    pair.textContent = mensagem;

    // Torna o pop-up visível
    popUp.style.display = "block";

    // Remove o pop-up após 5 segundos
    setTimeout(() => {
        popUp.style.display = "none";
    }, 3000);
}

// Função de edição do plano
function editarPlano(planoId) {
    const planoRow = document.querySelector(`#plano-${planoId}`);
    
    // Verifica se a linha do plano foi encontrada
    if (!planoRow) {
        console.error(`Plano com ID ${planoId} não encontrado.`);
        return;
    }

    const planoNomeCell = planoRow.querySelector(`.nome-plano`);
    const planoNomeDisplay = planoNomeCell.querySelector('.plano-nome-display');
    const planoNomeInput = planoNomeCell.querySelector('.plano-nome-input');

    // Verifica se os elementos de nome foram encontrados
    if (!planoNomeDisplay || !planoNomeInput) {
        console.error('Elementos de nome do plano não encontrados.');
        return;
    }

    // Alterna a exibição do nome e do campo de input
    planoNomeDisplay.style.display = 'none';
    planoNomeInput.style.display = 'block';
    planoNomeInput.value = planoNomeDisplay.textContent.trim(); // Preenche o input com o nome atual
    planoNomeInput.focus(); // Foca no input
    console.log(planoNomeInput)
    // Ao sair do campo de input ou pressionar Enter, salva a nova edição
    planoNomeInput.onblur = () => salvarEdicao(planoId, planoNomeInput.value, planoNomeDisplay, planoNomeInput);
    planoNomeInput.onkeypress = (event) => {
        if (event.key === 'Enter') {
            salvarEdicao(planoId, planoNomeInput.value, planoNomeDisplay, planoNomeInput);
        }
    };
}

// Função para salvar a edição do plano
function salvarEdicao(planoId, novoNome, planoNomeDisplay, planoNomeInput) {
    if (novoNome.trim() !== "") {
        fetch("editar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: planoId, nome: novoNome.trim() }) // Enviando o novo nome
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.sucesso) {
                planoNomeDisplay.textContent = novoNome.trim(); // Atualiza o nome exibido
                exibirPopup('Plano atualizado com sucesso!', true);
            } else {
                exibirPopup('Erro ao salvar dados', false);
            }
        })
        .catch(error => {
            console.error('Erro ao salvar os dados', error);
            exibirPopup('Erro de conexão ao atualizar.', false);
        });
    } else {
        exibirPopup('Nome do plano não pode ser vazio.', false);
    }

    // Restaura a exibição original
    planoNomeDisplay.style.display = 'block';
    planoNomeInput.style.display = 'none';
}

// Função para confirmar exclusão do plano
function confirmarExclusao(planoId, planoNome) {
    const messageDel = document.getElementById("message-del");
    messageDel.textContent = `Tem certeza que deseja excluir o plano: ${planoNome}?`;

    const popupDelBack = document.querySelector(".popup-del-back");
    popupDelBack.style.display = "block";

    document.getElementById("yes").onclick = function() {
        excluirPlano(planoId);
        popupDelBack.style.display = "none"; // Fecha o modal após a ação
    };

    document.getElementById("no").onclick = function() {
        popupDelBack.style.display = "none"; // Fecha o modal sem ação
    };
}

// Função para excluir plano
function excluirPlano(planoId) {
    fetch("deletar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: planoId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            const planoRow = document.querySelector(`#plano-${planoId}`);
            planoRow.remove(); // Remove a linha do plano excluído
            exibirPopup('Plano excluído com sucesso!', true);
        } else {
            exibirPopup('Erro ao excluir plano.', false);
        }
    })
    .catch(error => {
        console.error('Erro ao excluir plano', error);
        exibirPopup('Erro de conexão ao excluir.', false);
    });
}
