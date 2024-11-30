document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    const mensagem = body.getAttribute("data-mensagem");
    const cor = body.getAttribute("data-cor");
    if (mensagem) {
        const pop = document.querySelector(".pop");
        const pair = document.getElementById("pair");

        pair.textContent = mensagem; // Define o texto da mensagem
        pair.style.color = cor === "green" ? "green" : "red"; // Define a cor do fundo
        pop.style.display = "block"; // Exibe o pop-up
        setTimeout(() => {
            pop.style.display = "none"; // Esconde o pop-up após 3 segundos
        }, 3000); 
    }
    
    const areaSelect = document.getElementById('area');
    const especialidadeSelect = document.getElementById('especialidade');

    const especialidadesPorArea = {
        medico: [
            { value: 'Cardiologia', text: 'Cardiologia' },{ value: 'neurologia', text: 'Neurologia' },
            { value: 'Pediatria', text: 'Pediatria' },{ value: 'Dermatologia', text: 'Dermatologia' },
            { value: 'Radiologia', text:'Radiologia' },{value: 'Anestesiologia', text: 'Anestesiologia'}
        ],
        dentista: [
            { value: 'Ortodontia', text: 'Ortodontia' },{ value: 'Endodontia', text: 'Endodontia' },
            { value: 'Periodontia', text: 'Periodontia' },{ value: 'Estomatologista', text: 'Estomatologista' },
            { value: 'Implantodontia', text: 'Implantodontia' },{value:"Odontologia Estética",text:'Odontologia Estética'}
        ],
        nutricionista: [
            { value: 'Esportiva', text: 'Nutrição Esportiva' },{ value: 'Clínica', text: 'Nutrição Clínica' },
            { value: 'Infantil', text: 'Nutrição Infantil' },{ value: 'Comportamento Alimentar', text: 'Comportamento Alimentar' },
            { value: 'Nutrigenômica', text: 'Nutrigenômica' },{ value: 'Fitoterapia', text: 'Fitoterapia' },
        ],
        fisioterapeuta: [
            { value: 'Ortopédica', text: 'Fisioterapia Ortopédica' },{ value: 'Neurológica', text: 'Fisioterapia Neurológica' },
            { value: 'Cardiopulmonar', text: 'Fisioterapia Cardiopulmonar' },{ value: 'Geral', text: 'Fisioterapeuta Geral' },
            { value: 'Aquatíca', text: 'Fisioterapia Aquática.' },{ value: 'Acupuntura', text: 'Fisioterapia Acupuntura.' },
        ],
        psicologo: [
            { value: 'Juridica', text: 'Psicologia Jurídica' },{ value: 'Hospitalar', text: 'Psicologia Hospitalar' },
            { value: 'Especial', text: 'Psicologia Especial' },{ value: 'Esportiva', text: 'Psicologia do Esporte' },
            { value: 'Psicopedagogia', text: 'Psicopedagogia' },{ value: 'Organizacional', text: 'Psicologia Organizacional e do Trabalho' },
        ],
        exames: [
            { value: 'Laboratorial', text: 'Exames Laboratoriais' },{ value: 'Radiologia', text: 'Radiologia' },
            { value: 'Ultrassonografia', text: 'Ultrassonografia' },{ value: 'Glicemia', text: 'Glicemia' },
            { value: 'Urina', text: 'Exames de urina' },{ value: 'Colesterol', text: 'Colesterol' },
        ]
    };

    areaSelect.addEventListener('change', function () {
        especialidadeSelect.innerHTML = '<option value="" disabled selected>Selecione uma especialidade</option>';
        const areaSelecionada = areaSelect.value;
        const especialidades = especialidadesPorArea[areaSelecionada];
        if (especialidades) {
            // Popula o dropdown de especialidades com as opções da área selecionada
            especialidades.forEach(especialidade => {
                const option = document.createElement('option');
                option.value = especialidade.value;
                option.textContent = especialidade.text;
                especialidadeSelect.appendChild(option);
            });
        }
    });
});