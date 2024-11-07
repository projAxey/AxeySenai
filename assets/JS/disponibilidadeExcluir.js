document.addEventListener("DOMContentLoaded", function () {
    const excluirDisponibilidade = document.querySelectorAll('.excluiDisponibilidade'); // Usar querySelectorAll para múltiplos elementos com classe
    // console.log('Carregou Excluir');

    excluirDisponibilidade.forEach((botao) => { // Como 'excluirDisponibilidade' agora é uma NodeList, o forEach faz sentido
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const excluirdisponibildiadeId = botao.value; // Obtém o ID da disponibilidade a ser excluída
            // console.log(excluirdisponibildiadeId);

            try {
                // alert("try");
                // alert(excluirdisponibildiadeId);
                const resposta = await fetch(`../../backend/calendario/buscaAgendamentoDisponibilidades.php?id=${excluirdisponibildiadeId}`);
                // console.log(resposta)
                const statusData = await resposta.json();
                // console.log(statusData);

                if (statusData && "id_agendas" in statusData) {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Não é possível apagar disponibilidades pois existem agendamentos atralados ao mesmo."
                    });
                } else {
                    Swal.fire({
                        title: "Confirma a exclusão do agendamento?",
                        text: "Esta ação é irreversível e excluirá o agendamento permanentemente.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sim, excluir",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Se o usuário confirmar, chama a função para excluir o agendamento
                            excluirAgendamento(excluirdisponibildiadeId);
                        }
                    })
                }
            } catch (error) {
                console.error("Erro ao verificar o status do disponibilidades:", error);
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Ocorreu um erro ao tentar verificar o status do disponibilidades."
                });

            }

        });

    });
    async function excluirAgendamento(excluirdisponibildiadeId) {
        try {
            // Faz a requisição para o backend para excluir a disponibilidade
            const dados = await fetch(`../../backend/calendario/disponibilidadeExcluir.php?id=${excluirdisponibildiadeId}`);
            const retornaTexto = await dados.text(); // Pega a resposta como texto bruto
            // console.log(retornaTexto);

            try {
                let retorna = JSON.parse(retornaTexto); // Tenta converter para JSON
                // console.log(retorna);

                // Checa se a exclusão foi bem-sucedida com base no JSON retornado
                if (retorna['status']) {
                    Swal.fire({
                        icon: "success", // Exibe ícone de sucesso
                        title: "Sucesso",
                        text: retorna['msg']
                    }).then(() => {
                        // Apenas recarrega a página após o alerta ser fechado
                        // console.log("Tentando recarregar a página...");
                        window.location.reload(true);
                    });

                } else {
                    Swal.fire({
                        icon: "error", // Exibe ícone de erro
                        title: "Erro",
                        text: retorna['msg'],
                    });
                }
            } catch (jsonError) {
                // console.error("Erro ao processar JSON:", jsonError);
                Swal.fire({
                    icon: "error",
                    title: "Erro de resposta",
                    text: "A resposta do servidor não é um JSON válido."
                });
            }
        } catch (error) {
            // Trata erros de requisição
            // console.error("Erro na requisição:", error);
            Swal.fire({
                icon: "error",
                title: "Erro no servidor",
                text: "Houve um problema ao tentar excluir a disponibilidade.",
            });
        }
    }

});
