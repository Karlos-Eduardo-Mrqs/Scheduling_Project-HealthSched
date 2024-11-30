document.addEventListener("DOMContentLoaded", () => {
    const areaSelect = document.getElementById("Area");
    const especialidadeSelect = document.getElementById("Especialidade");
    const diasSelect = document.getElementById("Dias");
    const horarioSelect = document.getElementById("Horario");
    const paragrafo = document.getElementById("pair");
    const pop = document.querySelector(".pop");
    
    // Quando a área for alterada
    areaSelect.addEventListener('change', function () {
        const areaId = areaSelect.value;
        especialidadeSelect.disabled = !areaId;
        diasSelect.innerHTML = ''; // Limpa os dias disponíveis
        horarioSelect.innerHTML = ''; // Limpa os horários

        if (areaId) {
            buscarEspecialidades(areaId);
        } else {
            especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
        }
    });

    // Função para buscar especialidades via AJAX
    async function buscarEspecialidades(areaId) {
        try {
            const response = await fetch('PegarEspecialidades.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ area_id: areaId })
            });
            const especialidades = await response.json();
            preencherEspecialidades(especialidades);
        } catch {
            console.log("Erro ao buscar especialidades!", "error");
            especialidadeSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar especialidades</option>';
        }
    }

    // Função para preencher as especialidades no select
    function preencherEspecialidades(especialidades) {
        especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
        especialidades.forEach(especialidade => {
            const option = document.createElement("option");
            option.value = especialidade.id;
            option.textContent = especialidade.nome;
            especialidadeSelect.appendChild(option);
        });
    }

    async function carregarDiasDisponiveis() {
        const especialidade = especialidadeSelect.value;
        const area = areaSelect.value;
        diasSelect.innerHTML = ''; // Limpa os dias ao iniciar nova busca
    
        if (!especialidade || !area) {
            horarioSelect.innerHTML = ''; // Limpa os horários se faltar especialidade ou área
            return;
        }
    
        diasSelect.innerHTML = "<option>Carregando...</option>";
    
        try {
            const response = await fetch("buscandoDatas.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ especialidade })
            });
    
            const result = await response.json();  // Recebe a resposta como JSON
            console.log(result);  // Verifica o que está sendo retornado
            diasSelect.innerHTML = "";
    
            // Verifica se o status da resposta é sucesso
            if (result.status === 'success' && Array.isArray(result.dias) && result.dias.length > 0) {
                diasSelect.innerHTML = '<option value="" disabled selected>Escolha um dia disponível</option>';
                result.dias.forEach(dia => {
                    let option = document.createElement("option");
                    option.value = dia;
                    option.text = dia;
                    diasSelect.appendChild(option);
                });
            } else {
                diasSelect.innerHTML = '<option>Nenhum dia disponível</option>';
            }
        } catch (error) {
            console.log("Erro ao carregar os dias.", "error");
            console.error(error);  // Exibe o erro no console para depuração
        }
    }        

    // Atualiza os dias disponíveis ao mudar a especialidade
    especialidadeSelect.addEventListener('change', carregarDiasDisponiveis);

    async function carregarHorariosDisponiveis() {
        const especialidade = especialidadeSelect.value;
        const data = diasSelect.value;
        horarioSelect.innerHTML = ''; // Limpa os horários ao iniciar nova busca
    
        if (!especialidade || !data) {
            return; // Não faz nada se a especialidade ou a data não estiverem selecionadas
        }
    
        horarioSelect.innerHTML = "<option>Carregando...</option>";
    
        try {
            const response = await fetch("buscandoHorarios.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ especialidade, data })
            });
    
            const result = await response.json();  // Recebe a resposta como JSON
            horarioSelect.innerHTML = "";
    
            // Verifica se o status da resposta é sucesso
            if (result.status === 'success' && Array.isArray(result.horarios) && result.horarios.length > 0) {
                result.horarios.forEach(horario => {
                    let option = document.createElement("option");
                    option.value = horario;
                    option.text = horario;
                    horarioSelect.appendChild(option);
                });
            } else {
                horarioSelect.innerHTML = '<option>Nenhum horário disponível</option>';
            }
        } catch (error) {
            console.log("Erro ao carregar os horários.", "error");
            console.error(error);  // Exibe o erro no console para depuração
        }
    }
    
    // Atualiza os horários disponíveis ao mudar o dia
    diasSelect.addEventListener('change', carregarHorariosDisponiveis);
    
    document.getElementById("appointment-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Impede o envio do formulário antes da validação
        
        // Obtém os valores dos campos
        const area = document.getElementById("Area").value;
        const especialidade = document.getElementById("Especialidade").value;
        const dias = document.getElementById("Dias").value;
        const horario = document.getElementById("Horario").value;
        
        // Verifica se os campos estão preenchidos
        if (!area || !especialidade || !dias || !horario) {
            // Exibe uma mensagem de erro caso algum campo esteja vazio
            console.log("Por favor, preencha todos os campos antes de continuar.");
        } else {
            // Se todos os campos estão preenchidos, envia o formulário
            this.submit();
        }
    });
    
});