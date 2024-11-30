document.addEventListener("DOMContentLoaded", function () {
    // Exibe a mensagem pop-up se houver
    const body = document.body;
    const mensagem = body.getAttribute("data-mensagem");
    const cor = body.getAttribute("data-cor");

    if (mensagem) {
        const pop = document.querySelector(".pop");
        const pair = document.getElementById("pair");

        pair.textContent = mensagem; // Define o texto da mensagem
        pair.style.color = cor === "green" ? "green" : "red"; // Define a cor do texto
        pop.style.display = "block"; // Exibe o pop-up

        // Esconde o pop-up após 3 segundos
        setTimeout(() => {
            pop.style.display = "none"; 
        }, 3000); 
    }

    const areaSelect = document.getElementById('area');
    const especialidadeSelect = document.getElementById('especialidade');

    // Atualiza as especialidades ao selecionar uma área
    areaSelect.addEventListener('change', carregarEspecialidades);
    

    document.getElementById('area').addEventListener('change', function() {
        const areaId = this.value;
    
        // Realiza uma requisição para obter as especialidades com base na área selecionada
        fetch(`getEspecialidades.php?area_id=${areaId}`)
            .then(response => response.json())
            .then(data => {
                const especialidadeSelect = document.getElementById('especialidade');
                especialidadeSelect.innerHTML = ''; // Limpa opções anteriores
    
                data.forEach(especialidade => {
                    const option = document.createElement('option');
                    option.value = especialidade.id; // ID da especialidade
                    option.textContent = especialidade.nome; // Nome da especialidade
                    especialidadeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro:', error));
    });

    function carregarEspecialidades() {
        const areaSelect = document.getElementById("area");
        const especialidadeSelect = document.getElementById("especialidade");
        const areaSelecionada = areaSelect.value;
        
        // Limpar o campo de especialidade
        especialidadeSelect.innerHTML = "<option value='' disabled selected>Carregando...</option>";
    
        if (areaSelecionada) {
            fetch('Especialidades.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ area: areaSelecionada }) // Enviar a área
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da rede: ' + response.statusText);
                }
                return response.json(); // Tenta converter para JSON
            })
            .then(data => {
                // Limpar o campo de especialidade
                especialidadeSelect.innerHTML = "<option value='' disabled selected>Selecione a especialidade</option>";
                if (data.error) {
                    especialidadeSelect.innerHTML = `<option value='' disabled selected>${data.error}</option>`;
                } else {
                    data.forEach(function(especialidade) {
                        const option = document.createElement("option");
                        option.value = especialidade.id; // Atribui o ID como valor da opção
                        option.textContent = especialidade.nome; // Nome da especialidade
                        especialidadeSelect.appendChild(option); // Adiciona a opção ao select
                    });
                }
            })
            .catch(error => {
                especialidadeSelect.innerHTML = "<option value='' disabled selected>Erro ao carregar</option>";
                console.error('Erro ao carregar especialidades:', error);
            });
        } else {
            especialidadeSelect.innerHTML = "<option value='' disabled selected>Selecione a área de saúde primeiro</option>";
        }
    }
    const dropdowns = document.querySelectorAll(".multi-select-dropdown");

        dropdowns.forEach((dropdown) => {
            const btn = dropdown.querySelector(".dropdown-btn");
            const content = dropdown.querySelector(".dropdown-content");

            // Controla o abrir e fechar do dropdown
            btn.addEventListener("click", function () {
                content.classList.toggle("show");
            });

            // Fecha o dropdown se clicar fora dele
            document.addEventListener("click", function (e) {
                if (!dropdown.contains(e.target)) {
                    content.classList.remove("show");
                }
            });

            // Adiciona evento de clique em cada item do dropdown
            content.querySelectorAll("input[type='checkbox']").forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    atualizarSelecionados(dropdown, btn);
                });
            });
            });
        });

// Atualiza o texto do botão com os itens selecionados
    function atualizarSelecionados(dropdown, btn) {
        const checkboxes = dropdown.querySelectorAll("input[type='checkbox']:checked");
        const valoresSelecionados = Array.from(checkboxes).map((checkbox) => checkbox.nextElementSibling.textContent.trim());

        if (valoresSelecionados.length > 0) {
            btn.textContent = valoresSelecionados.join(", ");
        } else {
            btn.textContent = "Selecionar";
        }
    }
    
