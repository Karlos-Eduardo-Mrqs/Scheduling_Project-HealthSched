document.addEventListener("DOMContentLoaded", () => {
    const seeMoreButtons = document.querySelectorAll('.see-more');
    const popup = document.getElementById('popup');
    const popupTitle = document.getElementById('popup-title');
    const popupDescription = document.getElementById('popup-description');
    const popupImage = document.getElementById('popup-image');
    const popupServices = document.getElementById('popup-services');
    const popupContact = document.getElementById('popup-contact');
    const closeBtn = document.querySelector('.close-btn');

    // Atualizando as descrições
    const descriptions = {
        'Médicos': {
            description: 'Profissionais de saúde qualificados, prontos para oferecer atendimento em diversas especialidades médicas. Eles são responsáveis pelo diagnóstico, tratamento e prevenção de doenças, sempre focados na saúde e bem-estar dos pacientes.',
            image: './images/FotoDoutor.jpg',
            services: ['Consulta Geral', 'Especialidades Médicas', 'Tratamentos'],
        },
        'Dentistas': {
            description: 'Profissionais de saúde bucal qualificados, especializados em diagnosticar, tratar e prevenir problemas dentários. Eles cuidam da saúde dos dentes, gengivas e boca, oferecendo serviços que vão desde limpezas e restaurações até tratamentos ortodônticos e estéticos.',
            image: './images/FotoDentista.jpg',
            services: ['Limpeza Dental', 'Clareamento', 'Tratamentos Ortodônticos'],
        },
        'Nutricionistas': {
            description: 'Profissionais especializados em alimentação e nutrição, responsáveis por orientar sobre hábitos alimentares saudáveis. Eles avaliam as necessidades nutricionais dos pacientes e elaboram planos alimentares personalizados, visando promover a saúde e prevenir doenças.',
            image: './images/FotoNutricionista.jpg',
            services: ['Consultoria Alimentar', 'Planejamento de Dietas', 'Acompanhamento Nutricional'],
        },
        'Psicólogos': {
            description: 'Profissionais da saúde mental capacitados para ajudar na compreensão e resolução de questões emocionais e comportamentais. Eles utilizam técnicas terapêuticas para apoiar os pacientes na superação de dificuldades, promovendo o bem-estar e o autoconhecimento.',
            image: './images/FotoDoPsicologo.jpg',
            services: ['Terapia Individual', 'Terapia de Casal', 'Terapia Familiar'],
        },
        'Fisioterapeutas': {
            description: 'Profissionais de saúde especializados na prevenção, diagnóstico e tratamento de disfunções físicas. Eles utilizam técnicas manuais, exercícios e terapias para ajudar os pacientes a recuperar a mobilidade, aliviar a dor e melhorar a qualidade de vida.',
            image: './images/FotoFisioterapia.jpg',
            services: ['Reabilitação Pós-Cirúrgica', 'Fisioterapia Desportiva', 'Pilates Terapêutico'],
        },
        'Exames': {
            description: 'Procedimentos diagnósticos realizados para avaliar a saúde e detectar possíveis doenças. Eles podem incluir análises laboratoriais, exames de imagem e testes funcionais, fornecendo informações essenciais para o diagnóstico e acompanhamento de condições de saúde.',
            image: './images/FotoExame.png',
            services: ['Exames de Sangue', 'Ultrassom', 'Ressonância Magnética'],
        }
    };

    // Função para abrir o pop-up
    seeMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cardTitle = this.getAttribute('data-title'); // Acessa o valor do data-title

            // Verifica se o título corresponde a uma chave em `descriptions`
            if (descriptions[cardTitle]) {
                // Atualiza o título do pop-up
                popupTitle.textContent = cardTitle;

                // Atualiza a descrição do pop-up
                popupDescription.textContent = descriptions[cardTitle].description;

                // Atualiza a imagem do pop-up
                if (popupImage) {
                    popupImage.src = descriptions[cardTitle].image;
                    popupImage.alt = `Imagem de ${cardTitle}`;
                } else {
                    console.error('Elemento de imagem do pop-up não encontrado!');
                }

                // Atualiza os serviços
                if (popupServices) {
                    popupServices.innerHTML = descriptions[cardTitle].services.map(service => `<li>${service}</li>`).join('');
                } else {
                    console.error('Elemento de serviços do pop-up não encontrado!');
                }

                // Atualiza o contato
                if (popupContact) {
                    popupContact.textContent = descriptions[cardTitle].contact;
                } else {
                    console.error('Elemento de contato do pop-up não encontrado!');
                }

                // Exibe o pop-up
                popup.style.display = 'flex';
            } else {
                console.error(`Nenhuma descrição encontrada para o título: ${cardTitle}`);
            }
        });
    });

    // Função para fechar o pop-up
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });
    } else {
        console.error('Botão de fechar não encontrado!');
    }

    // Fecha o pop-up ao clicar fora da área de conteúdo
    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    });
});
