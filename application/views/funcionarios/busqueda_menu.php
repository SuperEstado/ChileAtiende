<div>
    <form action="<?= site_url('funcionarios/buscar') ?>" method="post" id="main_search">
        <input id="main_search_input" class="buscar" name="terminos_de_busqueda" type="text" placeholder="Ingrese el término" <?php echo (isset($terminos_de_busqueda)) ? "value='" . $terminos_de_busqueda . "'" : "" ?> />
        <input class="enviar" name="buscar" type="submit" value="buscar" />
    </form>
</div>