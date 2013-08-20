<?php if (isset($tag)) { ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= $site['site_name']; ?> | <?php echo $tag['tag_name']; ?></title>
        <link href="/includes/css/new_style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/text.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/print.css" rel="stylesheet" type="text/css" media="print">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="/includes/js/jquery.history.js"></script>
        <!--<script type="text/javascript" src="/includes/js/popstate.js"></script>-->

        <link rel="alternate" type="application/rss+xml" title="<?= $site['site_name']; ?> RSS" href="/rss/rss.xml">

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?= $site['google_analytics']; ?>']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
<?php } else { ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Language" content="en-gb">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= $site['site_name']; ?> | <?php echo $category['category_name']; ?><?php echo ($category['category_slug'] == "latest" ? '' : (strlen($sub_category['sub_category_name']) > 0 ? ' | '.$sub_category['sub_category_name'] : '')); ?></title>
        <meta name="description" content="<?php echo ($category['category_slug'] == "latest" ? $category['category_desc'] : ($sub_category ? $sub_category['sub_category_desc'] : $category['category_desc'])); ?>">
        <link href="/includes/css/new_style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/text.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/print.css" rel="stylesheet" type="text/css" media="print">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="/includes/js/jquery.history.js"></script>
        <!--<script type="text/javascript" src="/includes/js/popstate.js"></script>-->

        <link rel="alternate" type="application/rss+xml" title="<?= $site['site_name']; ?> RSS" href="/rss/rss.xml">

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?= $site['site_name']; ?>']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
<?php } ?>