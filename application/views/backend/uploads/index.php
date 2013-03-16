<div class="breadcrumb">
    <a href="<?= site_url('backend/portada') ?>">Administración</a> »
    <span>Carga de archivos</span>
</div>

<div class="pane">
    <h2>Carga de archivos</h2>

    <h3>Procedimiento</h3>
    <br />
    <ul style="list-style: disc inside none">
        <li>Arrastrar el o los archivo(s) al recuadro</li>
        <li>Los archivos deben tener el nombre sin espacio. ej: <strong>nombre de mi archivo.jpg</strong> reemplazar por <strong>nombre_de_mi_archivo.jpg</strong></li>
        <li>Los archivos deben contener <strong>nombres alfanuméricos</strong> (0-9 a-z) <strong>sin</strong> caracteres especiales (ñ, acentos, espacio, %, &, /, etc )</li>
        <li>Los archivos cargados deberán ser llamados de la forma: <strong><?=site_url('assets/uploads/')?>/nombre_de_mi_archivo.jpg</strong></li>
    </ul>
    <br />
    <div id="uploads">
        <noscript>			
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
        </noscript>
    </div>
</div>