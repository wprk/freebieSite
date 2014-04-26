<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Freebiersclub Admin</title>

    <link rel="stylesheet" href="/includes/css/admin.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/includes/css/chosen.min.css" type="text/css" media="screen"/>
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/includes/css/adm_ie.css" type="text/css" media="screen"/>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="/includes/js/hideshow.js" type="text/javascript"></script>
    <script src="/includes/js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/includes/js/jquery.equalHeight.js"></script>
    <script type="text/javascript" src="/includes/js/chosen.jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
                $(".tablesorter").tablesorter();
                $('#listing_tags').chosen({
                    allow_single_deselect: true,
                    skip_no_results: true,
                    create_option_text: 'Add Tag',
                    create_option: function(tag){
                          var chosen = this;
                          $.post('/s5k9d7f6jdn0/ajax/add_tag/', {tag_name: tag, ajax: '1'}).done(function(result) {
                                  values = $.parseJSON(result);
                                  chosen.append_option({
                                  value: values.tag_id,
                                  text: values.tag_name
                              });
                          });
                    }
                });
                $('#page_tags').chosen({
                    allow_single_deselect: true,
                    skip_no_results: true,
                    create_option_text: 'Add Tag',
                    create_option: function(tag){
                        var chosen = this;
                        $.post('/s5k9d7f6jdn0/ajax/add_tag/', {tag_name: tag, ajax: '1'}).done(function(result) {
                            values = $.parseJSON(result);
                            chosen.append_option({
                                value: values.tag_id,
                                text: values.tag_name
                            });
                        });
                    }
                });
                $('#listing_category_id').chosen({allow_single_deselect: true});
                $('#listing_sub_category_id').chosen({allow_single_deselect: true});
                $('#chosen_listings').chosen({allow_single_deselect: true});
        });
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
            jQuery("#listing_category_id").bind("load change", function () {
                jQuery("#listing_sub_category_id").find('option').remove();
                var url = '/s5k9d7f6jdn0/ajax/subcats/' + this.value;
                var options_array = new Array();
                var jqxhr = jQuery.get(url, function(data) {
                    options_array = data.split(',');
                    jQuery('#listing_sub_category_id').append(seloption);
                    jQuery.each(options_array,function(i){
                        var option_info = options_array[i].split('|');
                        jQuery('#listing_sub_category_id').append('<option value="' + option_info[0] + '">' + option_info[1] + '</option>');
                    });
                });
                var seloption = '<option value="0">Select a Sub Category</option>';
                jqxhr.always(function() {
                    jQuery("#listing_sub_category_id").trigger("liszt:updated")
                });
            });

            // Change category show new subcats
            jQuery("#chosen_listings").chosen().on("change", function(evt, params) {
                add_remove_homepage();
            });

            jQuery( "#chosen_listing_container" ).sortable({
                placeholder: "ui-state-highlight"
            });

            $( "#chosen_listing_container" ).on( "sortupdate", function( event, ui ) {
                update_homepage();
            });


            jQuery.datepicker.setDefaults({
                dateFormat: "yy-mm-dd",
                minDate: 1
            });
            jQuery(".datepicker").datepicker();

            function add_remove_homepage() {
                var currentListings = get_chosen_listing_ids();
                if (jQuery("#chosen_listings option:selected").length > currentListings.length) {
                    jQuery("#chosen_listings option:selected").each(function() {
                        if (jQuery.inArray(parseInt(this.value), get_chosen_listing_ids()) === -1) {
                            var newText = jQuery(this).text();
                            add_homepage_listing(this.value, newText);
                        }
                    });
                } else {
                    jQuery("#chosen_listing_container .chosen_listing").each(function() {
                        if (jQuery.inArray(parseInt($(this).data('listing-id')), get_selected_listing_ids()) === -1) {
                            remove_homepage_listing(parseInt($(this).data('listing-id')));
                        }
                    });
                }
            }
            function add_homepage_listing(newId, newText) {
                var url = '/s5k9d7f6jdn0/ajax/alter_homepage_listing';
                var listings = new Array();
                listings[0] = {};
                listings[0]['listing_id'] = parseInt(newId);
                listings[0]['listing_home_featured'] = 15;
                var jqxhr = jQuery.ajax({
                    type: 'post',
                    url: url,
                    data: {listings: listings},
                    dataType: "json"
                });
                jqxhr.always(function() {
                    jQuery('<div/>', {
                        class: 'chosen_listing',
                        'data-listing-id': newId,
                        text: newText
                    }).appendTo("#chosen_listing_container");
                });
            }

            function remove_homepage_listing(newId) {
                var url = '/s5k9d7f6jdn0/ajax/alter_homepage_listing';
                var listings = new Array();
                listings[0] = {};
                listings[0]['listing_id'] = newId;
                listings[0]['listing_home_featured'] = 0;
                var jqxhr = jQuery.ajax({
                    type: 'post',
                    url: url,
                    data: {listings: listings},
                    dataType: "json"
                });
                jqxhr.always(function() {
                    jQuery("#chosen_listing_container .chosen_listing").each(function() {
                        if (parseInt(jQuery(this).data('listing-id')) === newId) {
                            jQuery(this).remove();
                        }
                    });
                });
            }

            function update_homepage() {
                var url = '/s5k9d7f6jdn0/ajax/update_homepage';
                var listings = new Array();
                var count = 1;
                jQuery("#chosen_listing_container div.chosen_listing").each(function() {
                    var index = count - 1;
                        listings[index] = {};
                        listings[index]['listing_id'] = parseInt($(this).data('listing-id'));
                        listings[index]['listing_home_featured'] = count;
                    count++;
                });
                var jqxhr = jQuery.ajax({
                    type: 'post',
                    url: url,
                    data: {listings: listings},
                    dataType: "json"
                });
//                jqxhr.always(function() {
//                    jQuery("#chosen_listing_container").empty();
//                    jQuery("#chosen_listings option:selected").each(function() {
//                        jQuery('<div/>', {
//                            class: 'chosen_listing',
//                            'data-listing-id': $(this).value,
//                            text: $(this).text()
//                        }).appendTo("#chosen_listing_container");
//                    });
//                });
            }

            function get_chosen_listing_ids() {
                listingIds = new Array();
                jQuery("#chosen_listing_container div.chosen_listing").each(function() {
                    listingIds.push(jQuery(this).data('listing-id'));
                });
                return listingIds;
            }

            function get_selected_listing_ids() {
                listingIds = new Array();
                jQuery("#chosen_listings option:selected").each(function() {
                    listingIds.push(parseInt(this.value));
                });
                return listingIds;
            }
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
        <h1 class="site_title"><a href="/s5k9d7f6jdn0/">Freebiers Club Admin</a></h1>

        <h2 class="section_title"><?php echo $title; ?></h2>

        <div class="btn_view_site"><a href="/">View Site</a></div>
    </hgroup>
</header>
<!-- end of header bar -->

<section id="secondary_bar">
    <div class="user">
        <p><?php echo $user->fullname; ?></p>
        <a class="logout_user" href="/s5k9d7f6jdn0/auth/logout/" title="Logout">Logout</a>
    </div>
    <div class="breadcrumbs_container">
        <article class="breadcrumbs"><a href="/s5k9d7f6jdn0/">Dashboard</a>
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
        <li class="icn_edit_article"><a href="/s5k9d7f6jdn0/listings/">Listings</a> (<a class="no_icn" href="/s5k9d7f6jdn0/listings/add/">Add</a>)</li>
        <li><a href="/s5k9d7f6jdn0/manage_homepage/">Manage Homepage</a></li>
        <li><a href="/s5k9d7f6jdn0/listings/check/">Check Listings</a></li>
    </ul>
    <h3>Navigation</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="/s5k9d7f6jdn0/categories/">Categories</a> (<a class="no_icn" href="/s5k9d7f6jdn0/categories/add/">Add</a>)</li>
        <li class="icn_tags"><a href="/s5k9d7f6jdn0/tags/">Filters/Tags</a> (<a class="no_icn" href="/s5k9d7f6jdn0/tags/add/">Add</a>)</li>
        <li class="icn_tags"><a href="/s5k9d7f6jdn0/pages/">Landing Pages</a> (<a class="no_icn" href="/s5k9d7f6jdn0/pages/add/">Add</a>)</li>
    </ul>
    <h3>Other</h3>
    <ul class="toggle">
        <li class="icn_tags"><a href="/s5k9d7f6jdn0/sites/edit/">Sites</a> (<a class="no_icn" href="/s5k9d7f6jdn0/sites/add/">Add</a>)</li>
        <li class="icn_view_users"><a href="/s5k9d7f6jdn0/users/edit/">Users</a> (<a class="no_icn" href="/s5k9d7f6jdn0/users/add/">Add</a>)</li>
    </ul>
    <h3>Settings</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="#">Options</a></li>
        <li class="icn_jump_back"><a href="/s5k9d7f6jdn0/auth/logout/">Logout</a></li>
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

    <?php echo $content; ?>

</section>


</body>

</html>
