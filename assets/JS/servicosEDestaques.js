// Função para editar o serviço
function editService(produtoId) {
    fetch('../../backend/servicos/get_service.php?produto_id=' + produtoId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('editServiceForm').innerHTML = data; // Colocar o conteúdo no modal

            // Adiciona o listener de evento para o envio do formulário
            const form = document.getElementById('editServiceForm');
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Impede o envio padrão do formulário  

                const formData = new FormData(form); // Coleta os dados do formulário

                fetch('../../backend/servicos/update_service.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (response.ok) {
                            // Redireciona para a página principal após o sucesso
                            window.location.href = '/projAxeySenai/frontend/prestador/TelaMeusProdutos.php';
                        } else {
                            // Exibir erro
                            console.error('Erro ao atualizar produto');
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            });
        })
        .catch(error => console.error('Erro:', error));
}

// Função para confirmar a exclusão de um serviço
function confirmDelete(produtoId) {
    const confirmButton = document.getElementById('confirmDeleteButton');
    confirmButton.onclick = function () {
        // Cria um objeto FormData e adiciona o produto_id
        const formData = new FormData();
        formData.append('produto_id', produtoId);

        fetch('../../backend/servicos/delete_service.php', {
            method: 'POST',
            body: formData // Envia os dados usando FormData
        })
            .then(response => {
                if (response.ok) {
                    // Fechar o modal
                    const deleteModal = document.getElementById('deleteModal');
                    const modalInstance = bootstrap.Modal.getInstance(deleteModal);
                    modalInstance.hide(); // Usa Bootstrap 5 para fechar o modal

                    // Exibir mensagem de sucesso opcional
                    alert('Produto excluído com sucesso!'); // Alerta opcional

                    // Atualizar a lista de produtos
                    location.reload(); // Recarrega a página para refletir as mudanças
                } else {
                    // Exibir uma mensagem de erro caso a exclusão falhe
                    alert('Erro ao excluir o produto. Tente novamente.');
                }
            })
            .catch(error => console.error('Erro:', error));
    }
}


// Função para visualizar o serviço
function viewService(produtoId) {
    fetch('../../backend/servicos/view_service.php?produto_id=' + produtoId)
        .then(response => response.text())
        .then(data => {
            console.log(data)
            document.getElementById('serviceDetails').innerHTML = data; // Colocar o conteúdo no modal
        })
        .catch(error => console.error('Erro:', error));
}

// Função para visualizar as fotos do serviço
function viewPhotos(produtoId) {
    fetch('../../backend/servicos/get_service_photos.php?produto_id=' + produtoId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('serviceImages').innerHTML = data; // Colocar as imagens no modal
        })
        .catch(error => console.error('Erro:', error));
}

function formatPriceReversed(input) {
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres que não são dígitos
    if (value.length > 11) {
        value = value.slice(0, 11);
    }
    value = (parseInt(value, 10) / 100).toFixed(2); // Divide por 100 para obter os centavos
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    input.value = 'R$ ' + value;
}

function abrirDestaqueModal(produtoId, categoriaProduto) {
    if (categoriaProduto === 2) {
        // Se a categoria_produto é 2, chama o cancelamento de destaque
        confirmCancelDestaque(produtoId);
    } else {
        // Caso contrário, abre o modal para criar destaque (categoria_produto === 1)
        document.getElementById('produto_id_destacar').value = produtoId; // Passa o produto_id ao campo oculto no modal
        const destaqueModal = new bootstrap.Modal(document.getElementById('destaqueModal'));
        destaqueModal.show();
    }
}

/*********************************************************************** */
// Função para confirmar o cancelamento do destaque usando SweetAlert
function confirmCancelDestaque(produtoId) {
    Swal.fire({
        title: 'Atenção!',
        text: "Deseja realmente remover o destaque deste produto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Cancelar Destaque',
        cancelButtonText: 'Manter Destaque',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            cancelDestaque(produtoId);
        }
    });
}

// Função para enviar solicitação de cancelamento de destaque ao backend
function cancelDestaque(produtoId) {
    const formData = new FormData();
    formData.append('produto_id', produtoId);

    fetch('../../backend/servicos/cancel_destaque.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Cancelado!', 'Destaque removido com sucesso', 'success');
            location.reload(); // Recarrega a lista de produtos
        } else {
            Swal.fire('Erro', data.message || 'Não foi possível cancelar o destaque. Tente novamente.', 'error');
        }
    })
    .catch(error => {
        console.error('Erro ao cancelar destaque:', error);
        Swal.fire('Erro', 'Ocorreu um erro ao cancelar o destaque.', 'error');
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('mensagem_sucesso')) {
        Swal.fire({
            title: 'Sucesso!',
            text: 'Destaque criado com sucesso',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }
});


