<div>
    <ul class="listar_menu">
        <li><?= anchor("funcionarios/destacados","Destacados",((isset($listar_on) && $listar_on == 'destacados')?" class='on' ":"")); ?></li>
        <li><?= anchor("funcionarios/favoritos","Favoritos",((isset($listar_on) && $listar_on == 'favoritos')?" class='on' ":"")); ?></li>
        <li><?= anchor("funcionarios/servicios","Por Servicio",((isset($listar_on) && $listar_on == 'servicio')?" class='on' ":"")); ?></li>
    </ul>
</div>

