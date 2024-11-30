document.addEventListener('DOMContentLoaded', function () {
    const elements = {
        daysGrid: document.getElementById('daysGrid'),
        monthYear: document.getElementById('monthYear'),
        prevMonth: document.getElementById('prevMonth'),
        nextMonth: document.getElementById('nextMonth'),
        horariosListReservados: document.getElementById('horariosReservadosList'),
        horariosPreDefinidosContainer: document.getElementById('horariosDisponiveisList'),
        novoHorario: document.getElementById('novoHorario'),
        addHorario: document.getElementById('addHorario'),
        sendHorarios: document.getElementById('enviarHorarios'),
        pop: document.querySelector('.pop'),
        pair: document.getElementById('pair'),
        horariosContainer: document.getElementById('horariosContainer'),
        horariosListReservadosNovo: document.getElementById('horariosListReservados')
    };    

    const state = {
        currentDate: new Date(),
        selectedDateKey: '',
        horariosPorDia: {},
        horariosPreDefinidos: [
            "08:00:00", "08:30:00", "09:00:00", "09:30:00", "10:00:00", "10:30:00", "11:00:00", "11:30:00", "12:00:00", "12:30:00",
            "13:00:00", "13:30:00", "14:00:00", "14:30:00", "15:00:00", "15:30:00", "16:00:00", "16:30:00", "17:00:00", "17:30:00",
            "18:00:00", "18:30:00", "19:00:00", "19:30:00", "20:00:00"
        ]
    };

    
    const dayCells = document.querySelectorAll('.day');
    dayCells.forEach(dayCell => {
        dayCell.addEventListener('click', function () {
            dayCells.forEach(cell => cell.classList.remove('selected')); // Corrigir variável
            dayCell.classList.add('selected');
        });
    });

    function isValidDate(date) {
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(date);
    }
    
    // Função para formatar a data, se necessário (dependendo da sua implementação)
    function formatDate(date) {
        // Se a data já estiver no formato 'YYYY-MM-DD', pode não ser necessário fazer nada
        // Caso contrário, aqui você pode implementar a formatação necessária
        const d = new Date(date);
        return d.toISOString().split('T')[0]; // Retorna a data no formato 'YYYY-MM-DD'
    }
    
    function fetchHorarios(date) {        
        const formattedDate = formatDate(date); // Certifique-se que formatDate retorna no formato 'YYYY-MM-DD'
    
        if (!isValidDate(formattedDate)) {
            console.error('Formato de data inválido.');
            showPopup('Formato de data inválido.', 'red');
            return;
        }
    
        // Verifica se já temos os horários armazenados para a data
        if (state.horariosPorDia[formattedDate]) {
            return; // Evita novas requisições para a mesma data
        }
    
        fetch('reservados.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ date: formattedDate }) // Removido action: 'get'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                const horarios = data.horarios || [];
                if (Array.isArray(horarios) && horarios.length > 0) {
                    // Use Set apenas se necessário
                    const horariosUnicos = [...new Set(horarios)];
                    state.horariosPorDia[formattedDate] = horariosUnicos;
                } else {
                    state.horariosPorDia[formattedDate] = [];                }
            } else {
                showPopup(data.message || 'Erro desconhecido', 'red');
            }
        })
        .catch(error => {
            console.error('Erro ao buscar horários:', error);
            showPopup(error.message || 'Erro ao comunicar com o servidor', 'red');
        });
    }        

    // Atualiza o cabeçalho de mês e ano
    function updateMonthYear() {
        // Exibe a data formatada corretamente
        elements.monthYear.textContent = state.currentDate.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
    }

    // Renderiza o calendário com os dias do mês atual
    function renderCalendar() {
        elements.daysGrid.innerHTML = '';
        const firstDayOfMonth = new Date(state.currentDate.getFullYear(), state.currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(state.currentDate.getFullYear(), state.currentDate.getMonth() + 1, 0).getDate();

        createEmptyCells(firstDayOfMonth);
        createDaysCells(daysInMonth);
    }

    // Cria células vazias para o início do mês
    function createEmptyCells(count) {
        for (let i = 0; i < count; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'day empty';
            elements.daysGrid.appendChild(emptyCell);
        }
    }

    // Cria células de dias do mês
    function createDaysCells(daysInMonth) {
        Array.from({ length: daysInMonth }, (_, day) => day + 1).forEach(day => {
            const dayCell = document.createElement('div');
            dayCell.className = 'day';
            dayCell.textContent = day;

            if (isToday(day)) dayCell.classList.add('today');

            // Modificação aqui: passando o evento e o dia para a função selectDay
            dayCell.onclick = (event) => selectDay(event, day); 

            elements.daysGrid.appendChild(dayCell);
        });
    }

    // Verifica se é o dia atual
    function isToday(day) {
        const today = new Date();
        return day === today.getDate() && state.currentDate.getMonth() === today.getMonth() && state.currentDate.getFullYear() === today.getFullYear();
    }

    function formatHorario(horario) {
        const [hours, minutes] = horario.split(':');
        return `${hours}:${minutes}:00`; // Adiciona "00" para os segundos
    }

    function formatDate(date) {
        const d = new Date(date);
        return d.toISOString().split('T')[0]; // Retorna a data no formato 'YYYY-MM-DD'
    }
    
        // Função para exibir os horários
        function displayHorarios() {
            elements.horariosListReservados.innerHTML = '';  // Limpa a lista de horários reservados
            elements.horariosPreDefinidosContainer.innerHTML = '';  // Limpa os horários predefinidos
    
            // Exibe os horários reservados para a data selecionada
            if (state.horariosPorDia[state.selectedDateKey]?.length > 0) {
                const horariosReservados = state.horariosPorDia[state.selectedDateKey];
                createHorarioCheckboxSection(state.selectedDateKey, horariosReservados, 'reservados', elements.horariosListReservados, true);
            } else {
                const noHorariosMsg = document.createElement('div');
                noHorariosMsg.className = 'no-horarios';
                noHorariosMsg.textContent = 'Nenhum horário reservado para esta data.';
                elements.horariosListReservados.appendChild(noHorariosMsg);
            }
    
            // Exibe os horários predefinidos que ainda não foram reservados
            const horariosPreDefinidosFiltrados = state.horariosPreDefinidos.filter(horario => 
                !state.horariosPorDia[state.selectedDateKey]?.includes(horario)
            );
    
            if (horariosPreDefinidosFiltrados.length > 0) {
                const horariosPreDefinidosFormatados = [...new Set(horariosPreDefinidosFiltrados.map(formatHorario))];
                createHorarioCheckboxSection(state.selectedDateKey, horariosPreDefinidosFormatados, 'pre-definidos', elements.horariosPreDefinidosContainer, false);
            }
        }
        
    // Função para criar e adicionar a seção de checkboxes para os horários
    function createHorarioCheckboxSection(date, horarios, tipo, container, isReserved) {
        const section = document.createElement('div');
        section.className = `horarios-section ${tipo}`;

        horarios.forEach(horario => {
            const checkboxWrapper = document.createElement('div');
            checkboxWrapper.className = 'checkbox-wrapper';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `${tipo}_${horario}`;
            checkbox.name = `${tipo}[]`;
            checkbox.value = horario;

            if (isReserved) checkbox.disabled = true;

            const label = document.createElement('label');
            label.setAttribute('for', checkbox.id);
            label.textContent = horario;

            checkboxWrapper.appendChild(checkbox);
            checkboxWrapper.appendChild(label);
            section.appendChild(checkboxWrapper);
        });

        container.appendChild(section);
    }
    
    function showPopup(mensagem, cor) {
        const popup = document.querySelector('.pop');
        popup.style.color = cor;
        popup.textContent = mensagem;
        popup.style.display = 'block';
    
        setTimeout(() => {
            popup.style.display = 'none';
        }, 3000);
    }
    
    // Eventos para navegação entre os meses
    elements.prevMonth.onclick = () => {
        state.currentDate.setMonth(state.currentDate.getMonth() - 1);
        renderCalendar();
        updateMonthYear();
    };

    elements.nextMonth.onclick = () => {
        state.currentDate.setMonth(state.currentDate.getMonth() + 1);
        renderCalendar();
        updateMonthYear();
    };

    function selectDay(event, day) {
        document.querySelectorAll('.day').forEach(d => d.classList.remove('selected-day'));
        event.target.classList.add('selected-day');
        
        // Usa a função formatDate para formatar a data corretamente
        state.selectedDateKey = formatDate(`${state.currentDate.getFullYear()}-${state.currentDate.getMonth() + 1}-${day}`); 
        fetchHorarios(state.selectedDateKey); // Chama a função para buscar os horários
        displayHorarios();
    }

    // Evento para o botão de envio de horários
    elements.sendHorarios.addEventListener('click', enviarHorarios);

    function enviarHorarios() {
        // Verifica se uma data foi selecionada
        if (!state.selectedDateKey) {
            showPopup('Por favor, selecione uma data antes de enviar os horários.', 'red');
            return;
        }

        // Captura os horários selecionados
        const selectedHorarios = [];
        document.querySelectorAll('.horarios-section input[type="checkbox"]:checked').forEach(checkbox => {
            selectedHorarios.push(checkbox.value);
        });

        // Verifica se algum horário foi selecionado
        if (selectedHorarios.length === 0) {
            showPopup('Por favor, selecione pelo menos um horário.', 'red');
            return;
        }

        // Dados a serem enviados
        const dataToSend = {
            date: state.selectedDateKey,  // Data selecionada
            horarios: selectedHorarios    // Horários selecionados
        };

        // Envia os dados para o servidor com fetch
        fetch('enviar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dataToSend) // Envia os dados no corpo da requisição
        })
        .then(response => {
            // Verifica se a resposta do servidor foi bem-sucedida
            if (!response.ok) {
                throw new Error('Falha na comunicação com o servidor.');
            }
            return response.json(); // Converte a resposta para JSON
        })
        .then(data => {
            // Verifica o status da resposta
            if (data.status === "success") {
                showPopup('Horários enviados com sucesso!', 'green');
                // Após o sucesso, talvez você queira atualizar a lista de horários ou limpar os checkboxes
            } else {
                // Exibe a mensagem de erro do servidor, se houver
                showPopup(data.message || 'Erro desconhecido ao enviar horários.', 'red');
            }
        })
        .catch(error => {
            // Tratamento de erro em caso de falha na requisição ou outro erro
            console.error('Erro ao enviar horários:', error);
            showPopup(error.message || 'Erro ao comunicar com o servidor', 'red');
        });
    }    

    // Inicialização
    renderCalendar();
    updateMonthYear();

});