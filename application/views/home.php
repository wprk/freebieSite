<?php echo $header; ?>
<body>
<div id="wrap">
    <div id="header">
        <div class="wrap">
            <a name="top"></a>
            <a href="<?= site_url(); ?>"><img class="left" src="<?= site_url('/includes/images/logo.png'); ?>" alt="Freebiers Club Logo" height="48"></a>
            <a href="<?= site_url('/'.$category['category_slug'].'/'); ?>"><img class="right" src="<?= site_url('/includes/images/categories/'.($category['category_id'] ? $category['category_id'].'.png' : '0.png')); ?>" alt="<?php echo $category['category_name']; ?> Logo" height="48"></a>
        </div>
    </div>
    <div id="header_divider"></div>
    <?php echo $sub_categories_html; ?>
    <div id="content">
        <div class="wrap">
            <?php echo $listings_html; ?>
        </div>
    </div>
    <div id="push"></div>
</div>
<?php echo $footer; ?>