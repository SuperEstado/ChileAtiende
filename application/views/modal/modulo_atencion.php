<div id="moduloatencion" class="simpleOverlayModulos moduloatencion bienvenida">
<div class="logo"><img src="assets/images/logo_selecccion.png" alt="Logo ChileAtiende" /></div>
<div class="seleccion">
    <h2>Identifique su módulo de atención</h2>
    <div class="msgerror"></div>
    <form id="formModulo" method="post" action="">
          <p><select name="id_modulo" id="id_modulo" data-placeholder="Seleccione su Módulo" class="chzn-select">
            <option value=""></option>
            <?php
                    foreach ($modulos as $modulo) {
                        echo '<option value="' . $modulo->sector_codigo.'-'.$modulo->oficina_id.'-'.$modulo->nro_maquina . '" ' . '>' . $modulo->Oficina->nombre.' - Módulo '.$modulo->nro_maquina.' (' . $modulo->sector_codigo.'-'.$modulo->oficina_id.'-'.$modulo->nro_maquina . ')</option>';
                    }
                    ?>
            </select></p>
      <p><input id="setModulo" type="submit" value="Recordar" /></p>
      </form>
  </div>
</div>