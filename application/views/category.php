<?php echo $header; ?>
<body>
<div id="site_container">
<div id="header">
    <div class="wrap">
        <a name="top"></a>
        <a href="/"><img class="left" src="/includes/images/logo.png" alt="Freebiers Club Logo" height="48"></a>
        <img class="right" src="/includes/images/categories/<?php echo ($category['category_id'] ? $category['category_id'].'.png' : '0.png');?>" alt="<?php echo $category['category_name']; ?> Logo" height="48">
    </div>
</div>
<div id="header_divider"></div>
<?php echo $sub_categories_html; ?>
<div id="content">
    <div class="wrap">
        <?php echo $listings_html; ?>
    </div>
</div>
<?php echo $footer; ?>
