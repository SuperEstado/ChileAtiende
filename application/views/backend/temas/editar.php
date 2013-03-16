<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <a href="<?= site_url('backend/temas') ?>">Temas</a> »
    <span>Editar Tema #<?= $tema->id ?></span>
</div>

<div class="pane">
    <h2>Editar Tema</h2>

    <fieldset>
        <legend>Datos tema - <?= $tema->nombre ?></legend>
        <div class="validacion"></div>
        <form class="ajaxForm" action="<?= site_url('backend/temas/form_editar/' . $tema->id) ?>" method="post" >
            <table class="formTable">
                <tr>
                    <td>Nombre <span class="red">*</span></td>
                    <td><input type="text" name="nombre" size="50" value="<?= $tema->nombre ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><p class="red">* Campos Obligatorios</p></td>
                </tr>
                <tr>
                    <td colspan="2" class="botones">
                        <?php $this->load->view('backend/widgets/botones.php') ?>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
