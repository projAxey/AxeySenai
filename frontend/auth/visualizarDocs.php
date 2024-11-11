<?php
$termos = null;
$politica = null;
$id_termos = 2;
$id_politica = 1;

try {
    $stmt = $conexao->prepare("SELECT * FROM Documentos WHERE id = :id");
    $stmt->bindParam(':id', $id_termos);
    $stmt->execute();
    $termos = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->bindParam(':id', $id_politica);
    $stmt->execute();
    $politica = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar os documentos: " . $e->getMessage();
}
?>

<!-- Modal para Visualizar Documento -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #012640; color: #ffffff;">
        <div class="modal-body">
                <iframe id="documentViewer" src="" width="100%" height="500px" frameborder="0" style="background-color: #012640;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openDocument(caminho) {
        console.log(caminho);
        document.getElementById('documentViewer').src = '/projAxeySenai/files/documentos/' + encodeURIComponent(caminho);
    }
</script>