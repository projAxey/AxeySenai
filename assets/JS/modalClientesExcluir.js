document.addEventListener("DOMContentLoaded", function () {
    const excluirAgendamento = document.querySelectorAll('.excluiDisponibilidade'); // Usar querySelectorAll para múltiplos elementos com classe
    // console.log('Carregou Excluir');

    excluirDisponibilidade.forEach((botao) => { // Como 'excluirDisponibilidade' agora é uma NodeList, o forEach faz sentido
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const excluirAgendamentoID = botao.value; // Obtém o ID da disponibilidade a ser excluída
            // console.log(excluirdisponibildiadeId);

            try {
                // Faz a requisição para o backend para excluir a disponibilidade
                const dados = await fetch(`../../backend/calendario/disponibilidadeExcluir.php?id=${excluirAgendamentoID}`);
                const retorno = await dados; // Pega a resposta como texto bruto
                // console.log(retornaTexto);

                try {
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
        });
    });
});
