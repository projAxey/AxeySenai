<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
} elseif ($_SESSION['tipo_usuario'] != "Administrador") {
    header("Location: ../../index.php");
    exit();
}

include '../../config/conexao.php';
include '../layouts/head.php';
include '../layouts/nav.php';

$sql = "SELECT link_id, titulo_link, url_link, icon FROM LinksUteis";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-container">

    <body class="bodyCards">
        <main class="main-admin">
            <div class="container container-admin">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-admin">
                        <li class="breadcrumb-item">
                            <a href="admin.php" style="text-decoration: none; color:#012640;">
                                <strong>Voltar</strong>
                            </a>
                        </li>
                    </ol>
                </nav>
                <div class="title title-admin">GERENCIAR LINKS</div>
                <div class="table-responsive">
                    <div class="col-12 col-md-3">
                        <button type="button" id="novoLink" class="mb-2 btn btn-primary btn-novo-link"
                            style="background-color: #012640; color:white" data-bs-toggle="modal"
                            data-bs-target="#novoLinkModal">
                            Novo Link <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                    <table class="table table-striped table-striped-admin">
                        <thead>
                            <tr>
                                <th class="th-admin">TÍTULO</th>
                                <th class="th-admin">LINK</th>
                                <th class="th-admin">ICONE</th>
                                <th class="th-admin">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($links as $link): ?>
                                <tr>
                                    <td><?= htmlspecialchars($link['titulo_link']); ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($link['url_link']); ?>" target="_blank">
                                            <?= htmlspecialchars($link['url_link']); ?>
                                        </a>
                                    </td>
                                    <td><i class="<?= htmlspecialchars($link['icon']); ?>"></i></td>
                                    <td class="actions actions-admin">
                                        <button class="btn btn-sm btn-admin edit-admin" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-id="<?= $link['link_id']; ?>"
                                            data-title="<?= htmlspecialchars($link['titulo_link']); ?>"
                                            data-link="<?= htmlspecialchars($link['url_link']); ?>"
                                            data-icon="<?= htmlspecialchars($link['icon']); ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn btn-sm btn-admin delete-admin" data-id="<?= $link['link_id']; ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <div class="modal fade" id="novoLinkModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newLinkLabel">Adicionar Link Útil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formNovoLink">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título" required>
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL Link</label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="Digite o link URL" required>
                            </div>
                            <div class="mb-3">
                                <label for="icone" class="form-label">Ícone</label>
                                <input type="text" class="form-control" id="icone" name="icone" placeholder="Classe do ícone (ex: fa-brands fa-instagram)">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="formNovoLink" class="btn btn-primary mb-2"
                            style="background-color: #012640; color:white;">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit-title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-link" class="form-label">Link</label>
                            <input type="url" class="form-control" id="edit-link" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-icon" class="form-label">Ícone</label>
                            <input type="text" class="form-control" id="edit-icon">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" style="background-color: #012640; color:white;" id="saveEditButton">Salvar alterações</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="../../assets/JS/linksUteis.js"></script>
    </body>

    <!-- Footer incluído dentro do contêiner principal -->
    <?php include '../layouts/footer.php'; ?>
</div>