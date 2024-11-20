document.addEventListener("DOMContentLoaded", function () {
    const editaDisponibilidade = document.querySelectorAll('.editaDisponibilidade');
    
    // Captura o produtoId de forma segura
    var produtoId = null;
    var produtoElement = document.querySelector('.produto'); // Seleciona o primeiro elemento com a classe 'produto'
    if (produtoElement) {
        produtoId = produtoElement.getAttribute('data-id'); // Captura o ID do atributo data-id
    }
    if (!produtoId) {
        console.error("Produto ID não encontrado. Verifique o HTML.");
    }

    const statusElement = document.querySelector('.status');
    const statusValue = statusElement ? statusElement.getAttribute('data-status') : null; // Verifica se 'statusElement' existe
    console.log(statusValue);

    editaDisponibilidade.forEach((botao) => {
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const disponibilidadeId = botao.value; // Obtém o ID da disponibilidade a ser editada

            // Verifica se os IDs são válidos antes de continuar
            if (!disponibilidadeId || !produtoId) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "IDs inválidos para realizar a solicitação."
                });
                return;
            }

            try {
                if (statusValue === "false") {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "O perfil de acesso não é permitido para solicitar agendamentos."
                    });
                } else {
                    // Faz a requisição para o backend para buscar as informações da disponibilidade
                    const url = `../../backend/calendario/solicitaAgenda.php?id=${produtoId}&idagenda=${disponibilidadeId}`;
                    console.log(`URL usada: ${url}`);
                    
                    const dados = await fetch(url);
                    const resposta = await dados.json();

                    if (resposta.error) {
                        Swal.fire({
                            icon: "error",
                            title: "Erro",
                            text: resposta.error
                        });
                    } else {
                        // Preenche os campos do formulário com os dados da resposta
                        document.getElementById('idProduto').value = resposta.produto_id || "";
                        document.getElementById('idPrestador').value = resposta.prestador_agenda || "";
                        document.getElementById('nomeServico').value = resposta.nome_produto || "";
                        document.getElementById('descricaoServico').value = resposta.descricao_produto || "";
                        document.getElementById('idDisponibilidade').value = resposta.agenda_id || "";
                        document.getElementById('startDate').value = resposta.data_agenda || "";
                        document.getElementById('endDate').value = resposta.data_final || "";
                        document.getElementById('eventHoraInicio').value = resposta.hora_inicio || "";
                        document.getElementById('eventHoraFim').value = resposta.hora_final || "";

                        // Exibe o modal para o usuário editar as informações
                        const popupForm = document.getElementById('popupForm');
                        popupForm.style.display = "block"; // Mostra o modal (alterar para seu mecanismo de exibição)
                    }
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
    document.getElementById('close-cadastro-disponibilidade').addEventListener("click", function () {
        const popupForm = document.getElementById('popupForm');
        popupForm.style.display = "none"; // Esconde o modal
    });
});