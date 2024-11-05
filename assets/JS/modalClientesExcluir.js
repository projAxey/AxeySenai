document.addEventListener("DOMContentLoaded", function () {
    const excluirAgendamentoButtons = document.querySelectorAll('.excluiDisponibilidade');

    excluirAgendamentoButtons.forEach((button) => {
        button.addEventListener("click", async (event) => {
            event.preventDefault();
            const agendamentoId = button.value; // Obtém o ID do agendamento a ser excluído
            // alert(agendamentoId);

            try {
                alert("try")
                // Realiza a solicitação para verificar o status do agendamento
                const response = await fetch(`../../backend/calendario/buscaAgendamentoStatus.php?id=${agendamentoId}`);
                const statusData = await response.json();
                // alert(statusData.status);
                // console.log(statusData.status);

                if (statusData.status == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Não é possível apagar agendamentos aprovados. Entre em contato com o fornecedor."
                    });
                // } else if (statusData.status == 3) {
                //     Swal.fire({
                //         icon: "error",
                //         title: "Erro",
                //         text: "Não é possível apagar agendamentos recusados. Faça uma nova solicitação de reserva."
                //     });
                } else {
                    // Caso contrário, chama a função para excluir o agendamento se o status permitir
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
                            excluirAgendamento(agendamentoId);
                        }
                    })
                }

            } catch (error) {
                console.error("Erro ao verificar o status do agendamento:", error);
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Ocorreu um erro ao tentar verificar o status do agendamento."
                });
            }
        });
    });

    async function excluirAgendamento(id) {
        try {
            const response = await fetch(`../../backend/calendario/buscaAgendamentosExcluir.php?id=${id}`, {
                method: "GET"
            });
            
            const result = await response.json();
    
            if (result.status) { // verifica a chave 'status' no lugar de 'success'
                Swal.fire({
                    icon: "success",
                    title: "Agendamento Excluído",
                    text: result.msg // mensagem do PHP exibida na confirmação
                }).then(() => {
                    location.reload(); // Recarrega a página para atualizar a lista
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: result.msg // mensagem de erro específica do PHP exibida no alerta
                });
            }
    
        } catch (error) {
            console.error("Erro ao excluir o agendamento:", error);
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "Ocorreu um erro ao tentar excluir o agendamento."
            });
        }
    }
});