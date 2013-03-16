<?php
header ("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc><?php echo site_url() ?></loc>
        <changefreq>weekly</changefreq>
        <priority>1.000</priority>
    </url>
    <?php
    foreach ($publicadas as $p):
        ?>
        <url> 
            <loc><?php echo site_url('fichas/ver/'.$p->Maestro->id) ?></loc>
            <lastmod><?php echo strftime( "%Y-%m-%d", strtotime($p->updated_at) ) ?></lastmod>
            <changefreq><?php echo ($p->destacado) ? 'weekly' : 'monthly' ?></changefreq>
            <priority><?php echo ($p->destacado) ? '0.8000' : '0.5000' ?></priority>
            <xhtml:link rel="alternate" href="<?php echo site_url('movil/fichas/ver/'.$p->Maestro->id) ?>" />
        </url>
        <?php
    endforeach;
    ?>
</urlset>