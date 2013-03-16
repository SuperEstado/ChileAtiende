<div id="fichas">
    <div class="breadcrumb">
        <a href="<?= site_url('backend/portada') ?>">Administración</a> »
        <a href="<?= site_url('backend/fichas') ?>">Fichas</a> »
        <span>TopTen</span>
    </div>

    <table class="tabla">
        <tr>
            <th>Título</th>
            <th>Calificación</th>
        </tr>
        <?php
        foreach ($fichas as $ficha) {
        ?>
            <tr>
                <td><a title="<?= $ficha->titulo ?>" href="<?= site_url('backend/fichas/ver/' . $ficha->Maestro->id) ?>"><?= character_limiter($ficha->titulo,100) ?></a></td>
                <td><?= $ficha->rating ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

</div>
