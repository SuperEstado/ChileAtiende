<form class="filtro_titulo" method="post" action="<?= site_url('backend/fichas'.( ($flujos)?'/listarflujos':'') ) ?>" onChange="submit(); return true;">
    <select name="publico">
        <option value="">Seleccione</option>
        <option value="1">Personas</option>
        <option value="2">Empresas</option>
        <option value="3">Ambos</option>
    </select>
    <input type="hidden" name="entidad_codigo" value="<?=UsuarioBackendSesion::getEntidad()?>" />
    <input type="hidden" name="servicio_codigo" value="<?=UsuarioBackendSesion::getServicio()?>" />
</form>
