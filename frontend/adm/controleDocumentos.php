<?php include '../layouts/head.php';
include '../../config/conexao.php';
?>

<style>
    .label-custom {
        font-weight: bold;
        margin-right: 0.5rem;
    }

    .texto {
        font-size: 1.2rem;
    }

    /* Centralizar conteúdo da tabela */
    .table thead th,
    .table tbody td {
        text-align: center;
        vertical-align: middle;
    }
</style>


<?php
function edit_Document($conexao)
{
    if (isset($_POST['editDocument'])) {
        $id = $_POST['id'];
        $file = $_FILES['editFile']['tmp_name'];
        $fileName = $_FILES['editFile']['name'];
        $targetPath = '../../files/documentos/' . $fileName;

        // Primeiro, obtenha o caminho do arquivo atual
        $stmt = $conexao->prepare("SELECT caminho_arquivo FROM Documentos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $currentFilePath = $row['caminho_arquivo'];

            // Verifique se o arquivo atual existe e, se existir, exclua-o
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }
        }

        // Prepara a atualização do banco de dados
        $stmt = $conexao->prepare("UPDATE Documentos SET caminho_arquivo = :caminho_arquivo WHERE id = :id");
        $stmt->bindParam(':caminho_arquivo', $fileName);
        $stmt->bindParam(':id', $id);

        // Executa a atualização no banco de dados
        if ($stmt->execute()) {
            if (move_uploaded_file($file, $targetPath)) {
                header("Location: controleDocumentos.php");
                exit();
            } else {
                echo "Erro ao mover o arquivo.";
            }
        } else {
            echo "Erro ao atualizar o banco de dados.";
        }
    }
}

edit_Document($conexao);


?>


<body>
    <main class="main-admin">
        <div class="container container-admin">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-admin">
                    <li class="breadcrumb-item">
                        <a href="admin.php" style="text-decoration: none; color:#012640;"><strong>Voltar</strong></a>
                    </li>
                </ol>
            </nav>

            <div class="title-admin">GERENCIAR DOCUMENTOS</div>

            <div class="container my-5">
                <div class="table-responsive">
                    <table class="table table-striped table-striped-admin">
                        <thead>
                            <tr>
                                <th scope="col">Documento</th>
                                <th scope="col">Data de Atualização</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para obter os dados dos documentos
                            $sql = "SELECT id, nome_documento, data_atualizacao, caminho_arquivo FROM Documentos";
                            $stmt = $conexao->prepare($sql);
                            $stmt->execute();

                            // Verifica se existem resultados
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['nome_documento']) . "</td>";
                                    echo "<td>" . date('d/m/Y', strtotime($row['data_atualizacao'])) . "</td>";
                                    echo "<td class='d-flex justify-content-center gap-2'>";
                                    echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#viewModal' onclick=\"openDocument('" . ($row['caminho_arquivo']) . "')\">Visualizar</button>";
                                    echo "<button class='btn btn-secondary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' onclick=\"openEditModal(" . $row['id'] . ")\">Editar</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Nenhum documento encontrado.</td></tr>";
                            }
                            ?>

                            <?php include '../auth/visualizarDocs.php'; ?>

                            <!-- Modal para Editar Documento -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg d-flex align-items-center" style="min-height: 100vh;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Editar Documento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="controleDocumentos.php" method="post" enctype="multipart/form-data">
                                                <!-- Campo oculto para enviar o ID do documento -->
                                                <input type="hidden" id="documentId" name="id">
                                                <label for="editFile" class="form-label">Selecione um novo arquivo PDF para atualizar:</label>
                                                <input type="file" class="form-control" id="editFile" name="editFile" accept="application/pdf" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="editDocument">Salvar Alterações</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                        </form> <!-- Fechar a tag do formulário corretamente -->
                                    </div>
                                </div>
                            </div>

                </div>
    </main>
    <script>
        function openEditModal(documentId) {
            // Define o ID do documento na variável oculta no formulário
            document.querySelector('#documentId').value = documentId;
            // Atualiza a ação do formulário
            document.querySelector('#editModal form').action = `controleDocumentos.php?id=${documentId}`;
        }
    </script>
</body>