<form class="filtro_titulo" method="post" action="<?= site_url('backend/fichas'.( ($flujos)?'/listarflujos':'') ) ?>">
    <input type="text" name="titulo" size="65" value="" placeholder="Ingrese código, id o nombre del <?= ( ($flujos) ? 'flujo' : 'trámite' ) ?> que desea encontrar" />
        <input type="submit" class="boton_filtrar" value="Buscar" />
        <input type="hidden" name="entidad_codigo" value="<?=UsuarioBackendSesion::getEntidad()?>" />
        <input type="hidden" name="servicio_codigo" value="<?=UsuarioBackendSesion::getServicio()?>" />
</form>