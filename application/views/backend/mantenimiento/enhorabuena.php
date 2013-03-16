<div class="breadcrumb">
    <span>Wizard</span>
</div>

<div class="pane">
    <h3>Enhorabuena!</h3>
    <?php
    if(!empty($errores)) {
        echo '<ul>';
        echo $errores;
        echo '</ul>';
    } else {
        echo '<p>Los datos se han exportado exitosamente.</p>';
    }
    ?>
</div>