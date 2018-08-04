<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php if($urls){ ?>
<?php foreach($urls as $one){?>
    <url>
      <loc><?= $one['loc']?></loc>
      <priority><?= $one['priority']?></priority>
    </url>
<?php } ?>
<?php } ?>
</urlset>