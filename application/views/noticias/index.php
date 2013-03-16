<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix empresas">
        <div class="breadcrumbs"><a href="<?= site_url('/') ?>">Portada</a> / Noticias</div>
        <h2 class="title">Noticias</h2>
        
        <hr class="shadow" />
        <?php
        foreach ($noticias as $noticia) {
            ?>
            <div class="noticia clearfix">
                <h3 class="titular first_topic"><a href="<?= site_url('noticias/ver/' . $noticia->alias) ?>"><?= $noticia->titulo ?></a></h3>
                <p class="meta">Publicado el <?= date('j/m/Y', mysql_to_unix($noticia->created_at)) ?><a href="<?= site_url('noticias/ver/' . $noticia->alias) ?>" class="more">Seguir leyendo</a></p>
            </div>
            <?php
        }
        ?>
        <?= $this->pagination->create_links() ?>
    </div><!-- Content -->
</div>
<!-- Fin Contenido -->