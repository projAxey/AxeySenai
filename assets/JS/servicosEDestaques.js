// Função para editar o serviço
function editService(produtoId) {
    fetch('../../backend/servicos/get_service.php?produto_id=' + produtoId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('editServiceForm').innerHTML = data; // Coloca o conteúdo no modal

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
                            // Atualiza a página ou a seção após o envio bem-sucedido
                            window.location.href = '/projAxeySenai/frontend/prestador/TelaMeusAnuncios.php?edit_mensagem_sucesso=1';
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
document.addEventListener('DOMContentLoaded', function () {
    // Quando a modal de fotos for fechada, limpe o conteúdo
    const photosModal = document.getElementById('photosModal');
    photosModal.addEventListener('hidden.bs.modal', function () {
        // Limpa as imagens dentro da modal ao fechá-la
        const serviceImagesDiv = document.getElementById('photosModalContent');
        serviceImagesDiv.innerHTML = '';
    });
});

function viewPhotos(produtoId) {
    fetch('../../backend/servicos/get_service_photos.php?produto_id=' + produtoId)
        .then(response => response.json())
        .then(data => {
            const serviceImagesDiv = document.getElementById('photosModalContent');
            serviceImagesDiv.innerHTML = ''; // Limpa as imagens antigas

            if (data.success && data.images.length > 0) {
                // Itera sobre as imagens e as adiciona ao container
                data.images.forEach(imageUrl => {
                    const imgElement = document.createElement('img');
                    imgElement.src = imageUrl; // Define a URL da imagem
                    imgElement.classList.add('img-fluid', 'm-2'); // Adiciona classes Bootstrap para estilização
                    imgElement.style.maxWidth = '200px'; // Define um tamanho máximo para a imagem
                    serviceImagesDiv.appendChild(imgElement); // Adiciona a imagem ao container
                });

                // Abre a modal
                const photoModal = new bootstrap.Modal(document.getElementById('photosModal'));
                photoModal.show();
            } else {
                serviceImagesDiv.innerHTML = '<p>Nenhuma imagem disponível para este serviço.</p>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar imagens:', error);
            document.getElementById('photosModalContent').innerHTML = '<p>Erro ao carregar imagens.</p>';
        });
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
// Função para abrir a modal correta com base no valor de categoriaProduto
function abrirDestaqueModal(produtoId, categoriaProduto) {
    if (categoriaProduto === 1) {
        // Se categoria_produto é 1, abre a modal de criar destaque
        document.getElementById('produto_id_destacar').value = produtoId;
        const destaqueModal = new bootstrap.Modal(document.getElementById('destaqueModal'));
        destaqueModal.show();
    } else if (categoriaProduto === 2) {
        // Se categoria_produto é 2, abre a modal de remover destaque
        document.getElementById('produto_id_remover_destaque').value = produtoId;
        const removeDestaqueModal = new bootstrap.Modal(document.getElementById('removeDestaqueModal'));
        removeDestaqueModal.show();
    }
}
// Alerta de criação, remoção ou edição com sucesso
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    let mensagemTexto = null;
    if (urlParams.has('edit_mensagem_sucesso')) {
        mensagemTexto = 'Produto atualizado com sucesso!';
    } else if (urlParams.has('mensagem_sucesso')) {
        mensagemTexto = 'Destaque criado com sucesso!';
    } else if (urlParams.has('mensagem_remove')) {
        mensagemTexto = 'Destaque removido com sucesso!';
    }
    if (mensagemTexto) {
        Swal.fire({
            title: 'Sucesso!',
            text: mensagemTexto,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }
});

function fillPhotosModal(produtoId) {
    fetch('../../backend/servicos/view_service.php?produto_id=' + produtoId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('serviceDetails').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar informações do serviço:', error));
    const photosContainer = document.getElementById('service-photos-container');
    photosContainer.innerHTML = '';

    fetch('../../backend/servicos/get_service_photos.php?produto_id=' + produtoId)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.images.length > 0) {
                data.images.forEach(imageUrl => {
                    const imgElement = document.createElement('img');
                    imgElement.src = imageUrl;
                    imgElement.classList.add('img-fluid', 'm-2');
                    imgElement.style.maxWidth = '150px';
                    photosContainer.appendChild(imgElement);
                });
            } else {
                photosContainer.innerHTML = '<p>Nenhuma imagem disponível para este serviço.</p>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar imagens:', error);
            photosContainer.innerHTML = '<p>Erro ao carregar imagens.</p>';
        });
}


