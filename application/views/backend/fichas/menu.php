<?php
if(!isset($flujo))
    $flujo = FALSE;
?>
<ul class="tabs">
    <li><a <?= (isset($tab) && $tab=="ver")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'verflujo':'ver' ).'/' . $ficha->id) ?>">Ver</a></li>
    <?php
    if( ( ($this->user->tieneRol('editor')?'1':'0') ) && !(($ficha->locked)?'1':'0') ) {
    ?>
    <li><a <?= (isset($tab) && $tab=="editar")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'editarflujo':'editar' ).'/' . $ficha->id) ?>">Editar</a></li>    
    <?php
    }
    
    if( ($this->user->tieneRol('publicador')?'1':'0') && (($ficha->locked)?'1':'0') ) {
    ?>
    <li><a <?= (isset($tab) && $tab=="editar")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'editarflujo_ext':'editar_ext' ).'/' . $ficha->id) ?>">Editar Ext</a></li>
    <?php
    }
    ?>
    <li><a <?= (isset($tab) && $tab=="versiones")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'versionesflujo':'versiones' ).'/' . $ficha->id) ?>">Versiones</a></li>
    <li><a <?= (isset($tab) && $tab=="historial")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'historialflujo':'historial' ).'/' . $ficha->id) ?>">Historial</a></li>
    <?php
    if ( ($this->user->tieneRol(array('editor', 'aprobador', 'publicador'))) && ($ficha->publicado)  ) {
    ?>
    <li><a <?= (isset($tab) && $tab=="previsualizar")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'previsualizarflujo':'previsualizar' ).'/' . $ficha->id) ?>" class="popup">Previsualizar</a></li>
    <?php
    }
    ?>
    <li><a <?= (isset($tab) && $tab=="stats")?"class='active'":""; ?> href="<?= site_url('backend/fichas/'.( ($flujo)?'statsflujo':'stats' ).'/' . $ficha->id) ?>">Estadísticas</a></li>
</ul>