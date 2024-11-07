document.addEventListener('DOMContentLoaded', function() {
    const formNovoLink = document.getElementById('formNovoLink');
    const tableBody = document.querySelector('table tbody');

    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const editTitleInput = document.getElementById('edit-title');
    const editLinkInput = document.getElementById('edit-link');
    const editIconInput = document.getElementById('edit-icon');
    let currentEditId = null;

    function loadLinks() {
        fetch('../../backend/adm/linkControl.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    tableBody.innerHTML = '';
                    data.data.forEach(link => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${link.titulo_link}</td>
                            <td><a href="${link.url_link}" target="_blank">${link.url_link}</a></td>
                            <td><i class="${link.icon}"></i></td>
                            <td class="actions actions-admin">
                                <button class="btn btn-sm btn-admin edit-admin" data-id="${link.link_id}"
                                    data-title="${link.titulo_link}" data-link="${link.url_link}" data-icon="${link.icon}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-admin delete-admin" data-id="${link.link_id}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    console.error('Erro ao carregar links:', data.message);
                }
            })
            .catch(error => console.error('Erro:', error));
    }

    tableBody.addEventListener('click', function(event) {
        if (event.target.closest('.edit-admin')) {
            const button = event.target.closest('.edit-admin');
            currentEditId = button.getAttribute('data-id');
            editTitleInput.value = button.getAttribute('data-title');
            editLinkInput.value = button.getAttribute('data-link');
            editIconInput.value = button.getAttribute('data-icon');
            editModal.show();
        }

        if (event.target.closest('.delete-admin')) {
            const button = event.target.closest('.delete-admin');
            const linkId = button.getAttribute('data-id');

            Swal.fire({
                title: 'Você tem certeza?',
                text: "Esta ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#012640',
                cancelButtonColor: 'gray',
                confirmButtonText : 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`../../backend/adm/linkControl.php?id=${linkId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Excluído!',
                                text: data.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                loadLinks();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Erro ao tentar excluir o link.',
                            confirmButtonText: 'OK'
                        });
                        console.error('Erro:', error);
                    });
                }
            });
        }
    });

    document.querySelector('#editModal .btn-primary').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('id', currentEditId);
        formData.append('titulo', editTitleInput.value);
        formData.append('url', editLinkInput.value);

        if (editIconInput.value.trim() !== '') {
            formData.append('icone', editIconInput.value);
        }

        fetch('../../backend/adm/linkControl.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    editModal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao tentar editar o link.',
                confirmButtonText: 'OK'
            });
            console.error('Erro:', error);
        });
    });

    loadLinks();
});
