<?php echo $header; ?>
<body>
<div id="header">
    <div class="wrap">
        <a name="top"></a>
        <a href="/"><img class="left" src="/includes/images/logo.png" alt="Freebiers Club Logo" height="48"></a>
        <img class="right" src="/includes/images/tags/<?php echo ($tag['tag_id'] ? $tag['tag_id'].'.png' : '0.png');?>" alt="<?php echo $tag['tag_name']; ?> Logo" height="48">
    </div>
</div>
<div id="header_divider"></div>
<div id="content">
    <div class="wrap">
        <?php echo $listings_html; ?>
    </div>
</div>
<?php echo $footer; ?>
