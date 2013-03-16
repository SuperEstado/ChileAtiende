<?php /*?><?php $this->load->view("recomendacion/navegador_tematico.php"); ?><?php */?>

<div id="content" class="clearfix">
    <div id="maincontent" class="left clearfix empresas">
        <div class="breadcrumbs"><a href="<?= site_url('/') ?>">Portada</a> / <a href="<?= site_url('/noticias/') ?>">Noticias</a> / <?= $noticia->titulo ?></div>
        <h2 class="title"><?= $noticia->titulo ?></h2>

        <?php
            $this->load->view("fichas/access_share_menu.php");
        ?><br />
        <hr class="shadow" />
        <div class="noticia clearfix">
            <p class="meta">Publicado el <?= date('j/m/Y', mysql_to_unix($noticia->created_at)) ?></p>
            
            <?php if($noticia->foto){ ?>
            <div class="contenedor_imagen">
            	<img src="assets/timthumb/timthumb.php?zc=1&w=320&h=240&src=uploads/noticias/<?php echo $noticia->foto; ?>" alt="<?php echo $noticia->titulo; ?>" class="right" />
            	<?php if($noticia->foto_descripcion){ ?>
            		<div class="descripcion_imagen"><?php echo $noticia->foto_descripcion; ?></div>
            	<?php } ?>
            </div>
            <?php } ?>
            
            <?= $noticia->contenido ?>

        </div>

    </div><!-- Content -->
</div>