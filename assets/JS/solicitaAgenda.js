document.addEventListener("DOMContentLoaded", function () {
    const editaDisponibilidade = document.querySelectorAll('.editaDisponibilidade'); // Seleciona os botões de editar

    editaDisponibilidade.forEach((botao) => { 
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const disponibilidadeId = botao.value; // Obtém o ID da disponibilidade a ser editada
            alert(disponibilidadeId);

            try {
                // Faz a requisição para o backend para buscar as informações da disponibilidade
                const dados = await fetch(`/projAxeySenai/backend/calendario/solicitaAgenda.php?id=${disponibilidadeId}`);
                const resposta = await dados.json(); 

                if (resposta.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: resposta.error
                    });
                } else {
                    // Preenche os campos do formulário com os dados da resposta
                    document.getElementById('idProduto').value = resposta.produto_id;
                    document.getElementById('idDisponibilidade').value = resposta.agenda_id;
                    document.getElementById('startserviceDate').value = resposta.data_agenda;
                    document.getElementById('endserviceDate').value = resposta.data_final;
                    document.getElementById('eventHoraInicio').value = resposta.hora_inicio;
                    document.getElementById('eventHoraFim').value = resposta.hora_final;

                    // Exibe o modal para o usuário editar as informações
                    const popupForm = document.getElementById('popupForm');
                    popupForm.style.display = "block"; // Mostra o modal (alterar para seu mecanismo de exibição)
                }

            } catch (error) {
                // Trata erros de requisição
                Swal.fire({
                    icon: "error",
                    title: "Erro no servidor",
                    text: "Houve um problema ao tentar buscar os dados da disponibilidade.",
                });
            }
        });
    });

    // Fechar o modal ao clicar no botão "Fechar"
    document.getElementById('close-cadastro-disponibilidade').addEventListener("click", function() {
        const popupForm = document.getElementById('popupForm');
        popupForm.style.display = "none"; // Esconde o modal
    });
});
