<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Instituciones</span>
</div>



<div class="pane">
    <h2>Instituciones</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    <?php $this->load->view('backend/widgets/filtro_institucion') ?>
    
    <p><a class="boton" href="<?= site_url('backend/servicios/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Institución</a></p>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <table class="tabla">
        <?php
        $orden = '';
        $imagen_servicio = '';
        $imagen_entidad = $imagen_estado = '';
        
        switch ($this->input->get('field')) {
            case 'servicio':
                $orden = ($this->input->get('order_by') == 's.nombre ASC') ? 'DESC' : 'ASC';
                $imagen_servicio = ($this->input->get('order_by') == 's.nombre ASC') ? '<img src="assets/images/backend/arrow_up.png" border="0" />' : '<img src="assets/images/backend/arrow_down.png" border="0" />';
                break;
            case 'entidad':
                $orden = ($this->input->get('order_by') == 's.entidad_codigo ASC') ? 'DESC' : 'ASC';
                $imagen_entidad = ($this->input->get('order_by') == 's.entidad_codigo ASC') ? '<img src="assets/images/backend/arrow_up.png" border="0" />' : '<img src="assets/images/backend/arrow_down.png" border="0" />';
                break;
        }
        ?>
        <tr>
            <th class="sortable"><a href="<?= site_url('backend/servicios?field=servicio&order_by=s.nombre ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Institución</a><?= $imagen_servicio ?></th>
            <th class="sortable"><a href="<?= site_url('backend/servicios?field=entidad&order_by=s.entidad_codigo ' . ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset')) ?>">Entidad</a><?= $imagen_entidad ?></th>
            <th>Acción</th>
        </tr>
        <?php
        if (count($servicios)) {
            $cnt = 1;
            foreach ($servicios as $servicio) {
                $class = ($cnt & 1) ? 'odd' : 'even';
                
                $cntFichas = Doctrine::getTable('Servicio')->findConPublicaciones( array('servicio'=>$servicio->codigo, 'justCount'=>TRUE) );
                ?>
                <tr>
                    <td class="<?=$class?>"><?= $servicio->nombre ?></td>
                    <td class="<?=$class?>"><?= $servicio->Entidad->nombre ?></td>
                    <td class="<?=$class?>">
                        <?php
                        if (UsuarioBackendSesion::usuario()->tieneRol( array('publicador','mantenedor') )) {
                        ?>
                        <a href="<?= site_url('backend/servicios/editar/' . $servicio->codigo) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a> 
                        <?php
                            if( !$cntFichas ) {
                        ?>
                        <a href="<?= site_url('backend/servicios/borrar/' . $servicio->codigo) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Servicio?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>
                        <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $cnt++;
            }
        } else {
            ?>
            <tr>
                <td colspan="3" class="noregistros">No se encontraron registros</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php echo $this->pagination->create_links() ?>
    
</div>
