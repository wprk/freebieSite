<?php echo $header; ?>
<body>
<div id="header">
    <div class="wrap">
        <a name="top"></a>
        <a href="/"><img class="left" src="/includes/images/logo.png" alt="Freebiers Club Logo" height="48"></a>
        <!--<img class="right" src="/includes/images/categories/0.png" alt="Browse By Tag" height="48">-->
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
