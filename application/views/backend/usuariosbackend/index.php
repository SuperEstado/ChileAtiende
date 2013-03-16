<div class="breadcrumb">
    <a href="<?=site_url('backend/portada')?>">Administración</a> »
    <span>Usuarios</span>
</div>

<div class="pane">
    <h2>Usuarios Backend</h2>
    
    <?= $this->session->flashdata('message') ? '<div class="message">' . $this->session->flashdata('message') . '</div>' : '' ?>
    
    <p><a class="boton" href="<?= site_url('backend/usuariosbackend/agregar') ?>"><img src="assets/images/backend/add.png" /> Agregar Usuario</a></p>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php
    $orden = (strpos($order_by, "ASC") === FALSE)?"ASC":"DESC";
    ?>
    <table class="tabla">
        <tr>
            <th><a href="<?=site_url('backend/usuariosbackend?order_by=ub.nombres%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset'))?>">Nombres</a></th>
            <th><a href="<?=site_url('backend/usuariosbackend?order_by=ub.email%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset'))?>">Email</a></th>
            <th><a href="<?=site_url('backend/usuariosbackend?order_by=ub.servicio_codigo%20'. ( ($orden) ? $orden : 'DESC' ) . '&offset=' . $this->input->get('offset'))?>">Institución</a></th>
            <th>Roles</th>
            <th>Activo</th>
            <th>Acción</th>
        </tr>
        <?php
        $cnt = 1;
        foreach ($usuarios as $usuario) :
            $class = ($cnt & 1) ? 'odd' : 'even';
        ?>
            <tr>
                <td class="<?=$class?>"><a href="<?= site_url('backend/usuariosbackend/editar/' . $usuario->id) ?>"><?= $usuario->nombres ?> <?= $usuario->apellidos ?></a></td>
                <td class="<?=$class?>"><?= $usuario->email ?></td>
                <td class="<?=$class?>"><?php $servicios=array(); foreach($usuario->Servicios as $s)$servicios[]=$s->nombre; echo implode(',',$servicios)  ?></td>
                <td class="<?=$class?>"><?php foreach($usuario->Roles as $rol){ echo $rol->nombre." "; } ?></td>
                <td class="centrado <?=$class?>"><?= $usuario->activo ? '<img src="assets/images/backend/tick.png" alt="Activo" title="Activo" />' : '<img src="assets/images/backend/cross.png" alt="Inactivo" title="Inactivo" />'; ?></td>
                <td class="centrado <?=$class?>"><a href="<?= site_url('backend/usuariosbackend/editar/' . $usuario->id) ?>"><img src="assets/images/backend/pencil.png" alt="Editar" title="Editar" /></a><!-- <a href="<?= site_url('backend/usuariosbackend/borrar/' . $usuario->id) ?>" onclick="return confirm('¿Está seguro que desea eliminar este Usuario?')"><img src="assets/images/backend/delete.png" alt="Eliminar" title="Eliminar" /></a>--></td>
            </tr>
        <?php
            $cnt++;
        endforeach;
        ?>
    </table>
    
    <div class="contador"><span>Mostrando <?= $offset + 1 ?> - <?= min($offset + $per_page, $total) ?> de <?= $total ?> resultados</span></div>
    <?php echo $this->pagination->create_links() ?>

</div>
<?php
if(isset($_GET['order_by']) || isset($_GET['offset']))
    $this->session->set_flashdata('ruta', array('order_by'=>$_GET['order_by'],'offset'=>$_GET['offset']) );
?>