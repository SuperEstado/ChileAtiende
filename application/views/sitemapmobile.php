<?php
header ("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">
    <url>
        <loc><?php echo site_url('movil/') ?></loc>
        <priority>1.0</priority>
        <mobile:mobile/>
    </url>
    <?php
    foreach ($publicadas as $p):
        ?>
        <url> 
            <loc><?php echo site_url('movil/fichas/ver/'.$p->Maestro->id) ?></loc>
            <priority><?php echo ($p->destacado) ? '0.8000' : '0.5000' ?></priority>
            <mobile:mobile/>
        </url>
        <?php
    endforeach;
    ?>
</urlset>