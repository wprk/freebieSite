<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Freebiersclub Admin</title>

    <link rel="stylesheet" href="/includes/css/admin.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/includes/css/adm_ie.css" type="text/css" media="screen"/>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="/includes/js/jquery-1.5.2.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="/includes/js/hideshow.js" type="text/javascript"></script>
    <script src="/includes/js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/includes/js/jquery.equalHeight.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
                $(".tablesorter").tablesorter();
            }
        );
        $(document).ready(function () {

            //When page loads...
            $(".tab_content").hide(); //Hide all content
            if(location.hash) {
                $("li a[href$=" + location.hash.slice(1) + "]").parent().addClass("active");
                $("div" + location.hash).show(); //Show first tab content
            } else {
                $("ul.tabs li:first").addClass("active").show(); //Activate first tab
                $(".tab_content:first").show(); //Show first tab content
            }

            //On Click Event
            $("ul.tabs li").click(function () {

                $("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(".tab_content").hide(); //Hide all tab content
                $("#listings_changer").hide();


                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                if(activeTab == "#listings") {
                    $("#listings_changer").fadeIn();
                }
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });

            //On Select Change Event
            $("#listings_changer").bind('change', function () {
                $(".tablesorter tbody tr").hide(); //Hide all tab content
                var activeTab = 'tr.' + $(this).val(); //Find the href attribute value to identify the active tab + content
                $(activeTab).fadeIn(); //Fade in the active ID content
                return false;
            });

            // Confirm Prompt on Deletion
            jQuery("a.delete_action").bind("click", function () {
                text = 'This cannot be undone. Are you sure you wish to delete this?';
                var r = confirm(text);
                if(r == true) {
                    return true;
                } else {
                    return false;
                }
            });

            // Update alt description when default is changed (on add page only)
            jQuery("#add_listing_desc").bind("change", function () {
                newVal = jQuery(this).val();
                jQuery(".listing_alt_desc").val(newVal);
            });

            // Change category show new subcats
            jQuery("#listing_category_id").bind("change", function () {
                jQuery("#listing_sub_category_id").find('option').remove();
                var url = '/admin/action/get/subcats/' + this.value;
                var options_array = new Array();
                jQuery.get(url, function(data) {
                    options_array = data.split(',');
                    var seloption = '<option value="0">Select a Sub Category</option>';
                    jQuery.each(options_array,function(i){
                        var option_info = options_array[i].split('|');
                        seloption += '<option value="' + option_info[0] + '">' + option_info[1] + '</option>';
                    });
                    jQuery('#listing_sub_category_id').append(seloption);
                });
            });

            jQuery.datepicker.setDefaults({
                dateFormat: "yy-mm-dd",
                minDate: 1
            });
            jQuery(".datepicker").datepicker();

        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('.column').equalHeight();
        });
    </script>

</head>


<body>

<header id="header">
    <hgroup>
        <h1 class="site_title"><a href="/admin/">Freebiers Club Admin</a></h1>

        <h2 class="section_title"><?php echo $title; ?></h2>

        <div class="btn_view_site"><a href="/">View Site</a></div>
    </hgroup>
</header>
<!-- end of header bar -->

<section id="secondary_bar">
    <div class="user">
        <p><?php echo $user->fullname; ?></p>
        <a class="logout_user" href="/admin/logout/" title="Logout">Logout</a>
    </div>
    <div class="breadcrumbs_container">
        <article class="breadcrumbs"><a href="/admin/">Dashboard</a>
            <?php $i = 0; $count = count($breadcrumbs); foreach($breadcrumbs as $breadcrumb) { $i++ ?>
                <div class="breadcrumb_divider"></div>
                <a <?php echo (strlen($breadcrumb['url']) > 0 ? 'href="'.$breadcrumb['url'].'" ' : ''); ?>class="<?php echo ($i = $count ? 'current' : ''); ?>"><?php echo $breadcrumb['name'];?></a>
            <?php } ?>
        </article>
    </div>
</section>
<!-- end of secondary bar -->

<aside id="sidebar" class="column">
    <h3>Content</h3>
    <ul class="toggle">
        <li class="icn_new_article"><a href="/admin/add/listings/">Add New Listing</a></li>
        <li class="icn_edit_article"><a href="/admin/edit/listings/">Listings</a></li>
        <li><a href="/admin/check/listings/">Check Listings</a></li>
        <li class="icn_new_article"><a href="/admin/add/categories/">Add New Category</a></li>
        <li class="icn_categories"><a href="/admin/edit/categories/">Categories</a></li>
        <li class="icn_tags"><a href="/admin/edit/tags/">Filters/Tags</a></li>
    </ul>
    <h3>Users</h3>
    <ul class="toggle">
        <li class="icn_add_user"><a href="/admin/add/users/">Add New User</a></li>
        <li class="icn_view_users"><a href="/admin/edit/users/">Users</a></li>
    </ul>
    <h3>Settings</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="#">Options</a></li>
        <li class="icn_jump_back"><a href="/admin/logout/">Logout</a></li>
    </ul>

    <footer>
        <hr/>
        <p><strong>Copyright &copy; <?php echo date("Y"); ?> Freebiers Club Admin</strong></p>
    </footer>
</aside>
<!-- end of sidebar -->

<section id="main" class="column">

<?php foreach($messages as $message) { ?>
<h4 class="alert_<?php echo $message['type']; ?>"><?php echo $message['content']; ?></h4>
<?php } ?>

<?php echo $form_messages; ?>

<!-- This will house the analytics
<article class="module width_full">
    <header><h3>Stats</h3></header>
    <div class="module_content">
        <article class="stats_graph">
            <img
                src="http://chart.apis.google.com/chart?chxr=0,0,3000&chxt=y&chs=520x140&cht=lc&chco=76A4FB,80C65A&chd=s:Tdjpsvyvttmiihgmnrst,OTbdcfhhggcTUTTUadfk&chls=2|2&chma=40,20,20,30"
                width="520" height="140" alt=""/>
        </article>

        <article class="stats_overview">
            <div class="overview_today">
                <p class="overview_day">Today</p>

                <p class="overview_count">1,876</p>

                <p class="overview_type">Hits</p>

                <p class="overview_count">2,103</p>

                <p class="overview_type">Views</p>
            </div>
            <div class="overview_previous">
                <p class="overview_day">Yesterday</p>

                <p class="overview_count">1,646</p>

                <p class="overview_type">Hits</p>

                <p class="overview_count">2,054</p>

                <p class="overview_type">Views</p>
            </div>
        </article>
        <div class="clear"></div>
    </div>
</article>
-->

<?php echo $content; ?>
</section>


</body>

</html>