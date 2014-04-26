<?php if (isset($page)) {
    $page_title = $page['page_name'] . ' | ' . $site['site_name'];
    $page_desc = ''; //$page['page_desc'];
} else if (isset($tag)) {
    $page_title = $tag['tag_name'] . ' | ' . $site['site_name'];
    $page_desc = ''; //$page['page_desc'];
} else if (isset($listing)) {
    $page_title = $listing['listing_title'] . ' | ' . $site['site_name'];
    $page_desc = $listing['listing_title'];
} else {
    $page_title = ($category['category_slug'] == "latest" ? 'latest freebies' : ($sub_category['sub_category_name'] > 0 ? $sub_category['sub_category_name'] : $category['category_name'])) . ' | ' . $site['site_name'];
    $page_desc = ($category['category_slug'] == "latest" ? $category['category_desc'] : ($sub_category ? $sub_category['sub_category_desc'] : $category['category_desc']));
}?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title><?= $page_title; ?></title>
        <meta name="description" content="<?= $page_desc; ?>" />

        <!-- Google Authorship and Publisher Markup -->
<!--        <link rel="author" href="https://plus.google.com/[Google+_Profile]/posts"/>-->
<!--        <link rel="publisher" href=”https://plus.google.com/[Google+_Page_Profile]"/>-->

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?= $page_title; ?>">
        <meta itemprop="description" content="<?= $page_desc; ?>">
        <meta itemprop="image" content="<?= 'http://' . $site['site_url'] . '/includes/images/' . $site['site_name'] . '-logo.png'; ?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="<?= $site['site_summary']; ?>">
        <meta name="twitter:site" content="<?= $site['twitter_handle']; ?>">
        <meta name="twitter:title" content="<?= $page_title; ?>">
        <meta name="twitter:description" content="<?= $page_desc; ?>">
        <meta name="twitter:creator" content="<?= $site['twitter_handle']; ?>">
        <meta name="twitter:image" content="<?= 'http://' . $site['site_url'] . '/includes/images/' . $site['site_name']; ?>-logo.png">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?= $page_title; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?= $site['site_url']; ?>" />
        <meta property="og:image" content="<?= 'http://' . $site['site_url'] . '/includes/images/' . $site['site_name'] . '-logo.png'; ?>" />
        <meta property="og:description" content="<?= $page_desc; ?>" />
        <meta property="og:site_name" content="<?= $site['site_name']; ?>" />
        <meta property="fb:admins" content="<?= $site['facebook_handle']; ?>" />

        <link href="/includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/text.css" rel="stylesheet" type="text/css" media="screen">
        <link href="/includes/css/print.css" rel="stylesheet" type="text/css" media="print">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="/includes/js/bootstrap.min.js"></script>
        <!--<script type="text/javascript" src="/includes/js/jquery.history.js"></script>
        <script type="text/javascript" src="/includes/js/popstate.js"></script>-->

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
