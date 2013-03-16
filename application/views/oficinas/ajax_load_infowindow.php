<div style="height: 120px">
<table>
    <tr>
        <th>Sucursal</th>
        <td><?=$oficina->nombre?></td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td><?=$oficina->direccion?></td>
    </tr>
    <tr>
        <th>Comuna</th>
        <td><?=$oficina->Sector->nombre?></td>
    </tr>
    <tr>
        <th>Horario</th>
        <td><?=$oficina->horario?></td>
    </tr>

</table>
</div>