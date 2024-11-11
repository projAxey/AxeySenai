<?php
try {
    // Consulta para buscar os ícones e URLs de redes sociais da tabela LinksUteis
    $sql = "SELECT url_link, icon FROM LinksUteis";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $socialLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Caso ocorra um erro, pode-se exibir uma mensagem para desenvolvedores
    error_log("Erro ao buscar links: " . $e->getMessage());
    $socialLinks = [];
}
?>

<?php

include $_SERVER['DOCUMENT_ROOT'] . '/projAxeySenai/frontend/auth/visualizarDocs.php';

?>
<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Sobre Nós</h5>
                <p>Aqui você encontra diversas informações de serviços para seu dia a dia.</p>
            </div>
            <div class="col-md-4">
                <h5>Navegação</h5>
                <ul class="list-unstyled">
                    <li><a href="\projAxeySenai\index.php">Início</a></li>
                    <li><a href="\projAxeySenai\frontend\planos\planos.php">Planos</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#contactModal">Contato</a></li>
                    <?php if ($termos): ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $termos['caminho_arquivo'] ?>')">Termos de Uso</a></li>
                    <?php else: ?>
                        <li>Termos de Uso não disponível</li>
                    <?php endif; ?>
                    <?php if ($politica): ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $politica['caminho_arquivo'] ?>')">Politica de Privacidade</a></li>
                    <?php else: ?>
                        <li>Politica de Privacidade</li>
                    <?php endif; ?>
                </ul>

            </div>
            <div class="col-md-4">
                <h5>Redes Sociais</h5>
                <div class="social-links">
                    <?php
                    // Itera sobre cada link de rede social e exibe o ícone
                    foreach ($socialLinks as $link) {
                        echo '<a href="' . htmlspecialchars($link['url_link']) . '" target="_blank">';
                        echo '<i class="' . htmlspecialchars($link['icon']) . '"></i>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center mt-3">
            <p>© <span id="current-year"></span> Axey. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<!-- Modal de Contato -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Contato com os Desenvolvedores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <!-- Tabela com informações dos desenvolvedores -->
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Contato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Affonso Davi da Silva</td>
                            <td>affonsodavi@gmail.com</td>
                            <td><a href="https://wa.me/5547988671192" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>luis</td>
                            <td>luis@gmail.com</td>
                            <td><a href="https://wa.me/5511999999999" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Mling</td>
                            <td>mling@gmail.com</td>
                            <td><a href="https://wa.me/5511999999999" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Pavesi</td>
                            <td>pavesi@gmail.com</td>
                            <td><a href="https://wa.me/5511999999999" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Rossini</td>
                            <td>rossini@gmail.com</td>
                            <td><a href="https://wa.me/5511999999999" target="_blank" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilos CSS adicionais -->
<style>
    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .btn-success {
        background-color: #25D366;
        /* Cor padrão do WhatsApp */
        border-color: #25D366;
    }

    .btn-success:hover {
        background-color: #128C7E;
        border-color: #128C7E;
    }

    .modal-body {
        padding: 20px;
    }
</style>


<script>
    // Script para exibir o ano atual no footer
    document.getElementById("current-year").textContent = new Date().getFullYear();
</script>