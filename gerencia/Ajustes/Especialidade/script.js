document.addEventListener('DOMContentLoaded', function() {
    const areaSelect = document.getElementById('area-select');
    const especialidadeSelect = document.getElementById('especialidade-select');
    const formAreaSelect = document.getElementById('area');
    const formContainer = document.querySelector(".form-container");
    
    const formDadosEspecialidade = document.getElementById('especialidade-form');
    const formEspecialidade = document.getElementById('form-dados-especialidade');    
    const nomeEspecialidadeInput = document.getElementById('nova_especialidade');
    
    const mostrarEdicaoBtn = document.getElementById('mostrar-edicao-btn');  
    const cancelarEdicaoBtn = document.querySelector('.form-card button[type="button"]'); // Botão "Cancelar Edição"
    
    const mensagem = document.body.getAttribute('data-mensagem');
    const cor = document.body.getAttribute('data-cor');

    if (mensagem && cor) {
        exibirPopUp(mensagem, cor); // Exibe o pop-up com a mensagem e cor armazenadas na sessão
    }

    // Função para preencher o select de especialidades
    function preencherEspecialidades(especialidades) {
        especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
        especialidades.forEach(especialidade => {
            const option = document.createElement('option');
            option.value = especialidade.id;
            option.textContent = especialidade.nome;
            especialidadeSelect.appendChild(option);
        });
    }

    // Evento para carregar as especialidades ao selecionar uma área
    areaSelect.addEventListener('change', function() {
        const areaId = areaSelect.value;
        if (areaId) {
            especialidadeSelect.disabled = false;

            fetch('PegarEspecialidades.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ area_id: areaId }),
            })
            .then(response => response.json())
            .then(especialidades => {
                preencherEspecialidades(especialidades);
            })
            .catch(error => {
                exibirPopUp("Erro ao buscar especialidades ! ","red");
                especialidadeSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar especialidades</option>';
            });
        } else {
            especialidadeSelect.disabled = true;
            especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
        }
    });

    // Evento para mostrar o formulário de edição ao clicar no botão "Mostrar Edição"
    mostrarEdicaoBtn.addEventListener('click', function() {
        const especialidadeId = especialidadeSelect.value;
        if (especialidadeId && especialidadeId !== 'undefined') {
            fetch('FormEspecialidade.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ especialidade_id: especialidadeId })
            })
            .then(response => response.json())
            .then(especialidade => {    
                if (especialidade.error) {
                    exibirPopUp(`${especialidade.error}`,"red");
                } else {
                    // Criar um novo campo oculto para o ID da especialidade
                    const especialidade_id = document.createElement("input");
                    especialidade_id.type = "hidden";
                    especialidade_id.name = "especialidade_id";
                    especialidade_id.value = especialidadeId; // Certifique-se que o valor seja o correto

                    formEspecialidade.appendChild(especialidade_id);

                    // Preencher os campos com os dados da especialidade
                    nomeEspecialidadeInput.value = especialidade.especialidade_nome;
                    if (formAreaSelect) {
                        formAreaSelect.value = especialidade.area_id;
                    }

                    // Exibir o formulário de edição e ocultar a área inicial
                    formContainer.style.display = "none";
                    formDadosEspecialidade.style.display = 'block';
                }                    
            })
            .catch(error => {
                console.error('Erro ao carregar os dados da especialidade:', error);
                exibirPopUp('Erro ao carregar os dados da especialidade','red');
            });            
        } else {
            exibirPopUp('Selecione uma especialidade primeiro','red');
        }
    });

    cancelarEdicaoBtn.addEventListener('click', function() {
        // Esconde o formulário de edição
        formDadosEspecialidade.style.display = 'none';

        formContainer.style.display = 'block';
    });

    function exibirPopUp(mensagem, cor) {
        let pop = document.querySelector('.pop');
        const pair = document.getElementById('pair');
        
        if (pair) {  // Verifica se o elemento foi encontrado
            pair.innerText = mensagem;
            pair.style.color = cor;
        } else {
            console.error("Elemento com ID 'pair' não encontrado.");
        }
    
        // Exibe o pop-up
        pop.style.display = "block";
    
        // Define um tempo para esconder o pop-up depois de 3 segundos
        setTimeout(() => {
            pop.innerHTML = ''; // Limpa o pop-up
            pop.style.display = "none";
        }, 3000);
    }
});
