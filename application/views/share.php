<?php echo $header; ?>
<body>
<div id="site_container">
    <div id="header">
        <div class="wrap">
            <a name="top"></a>
            <a href="/"><img class="left" src="/includes/images/logo.png" alt="Freebiers Club Logo" height="48"></a>
            <a href="/<?= $listing['category_slug']; ?>/"><img class="right" src="/includes/images/categories/<?= $listing['category_id']; ?>.png" alt="Browse By Tag" height="48"></a>
        </div>
    </div>
    <div id="header_divider"></div>
    <?php echo $sub_categories_html; ?>
    <div id="content">
        <div class="wrap">
            <!-- Share page starts here -->
            <div class="share_left">
                <!-- larger content -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-5239608422081333"
                     data-ad-slot="7101112883"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="share_right">
                <div class="share_listing" itemscope itemtype="http://schema.org/Product">
                    <div class="list_img">
                        <a href="<?= $listing['listing_url']; ?>" target="_blank">
                            <img itemprop="image" class="img-rounded" src="/includes/images/listings/<?php echo $listing['img_url'];?>" width="150" height="150" alt="<?php echo $listing['listing_title'];?>">
                        </a>
                    </div>
                    <div class="list_title">
                        <a href="<?= $listing['listing_url']; ?>" class="external title" target="_blank" itemprop="url">
                            <span itemprop="name"><?php echo $listing['listing_title'];?></span>
                        </a>
                        <?php echo (strlen($listing['listing_tracking_img']) > 0 ? '<img src="'.$listing['listing_tracking_img'].'" width="1" height="1" style="float:right;" />' : '') ; ?>
                    </div>
                    <div class="list_desc expired" itemprop="description">
                        <?= $listing['listing_desc']; ?>
                    </div>
                    <div class="list_share crumbs">
                        <!-- AddThis Button BEGIN -->
                        <?php $server_img_path = realpath(BASEPATH . '../includes/images/listings/'.$listing['listing_uri'].'-lrg.png'); ?>
                        <?php $media_link = 'http://'.$site['site_url'].(file_exists($server_img_path) ? '/includes/images/listings/'.$listing['listing_uri'].'-lrg.png' : '/includes/images/listings/'.$listing['img_url']); ?>
                        <div class="addthis_toolbox addthis_default_style"
                             addthis:url="http://<?= $site['site_url']; ?>/<?= $listing['listing_uri']; ?>"
                             addthis:title="<?= $listing['listing_title']; ?>"
                             pi:pinit:media="<?=$media_link;?>"
                             addthis:description="<?= $listing['listing_desc']; ?>">
                            <span class="share">share:</span>
                            <a class="addthis_button_facebook"><img src="/includes/images/share_icons/share-fb-logo.png" width="16" height="16"><span class="share-label">facebook</span></a>
                            <a class="addthis_button_twitter" addthis:title="<?= $listing['listing_title']; ?> - <?= $media_link; ?>"><img src="/includes/images/share_icons/share-tw-logo.png" width="16" height="16"><span class="share-label">twitter</span></a>
                            <a class="addthis_button_google_plusone_share" addthis:title="<?= $listing['listing_title']; ?>" ><img src="/includes/images/share_icons/share-gp-logo.png" width="16" height="16"><span class="share-label">google+</span></a>
                            <a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=http://<?= $site['site_url']; ?>/<?= $listing['listing_uri']; ?>&media=<?=$media_link;?>&description=<?= urlencode($listing['listing_title']); ?>%20-%20<?= urlencode($listing['listing_desc']); ?>" data-pin-do="buttonPin" data-pin-config="above">
                                <img src="/includes/images/share_icons/share-pn-logo.png" width="16" height="16"><span class="share-label">pinterest</span>
                            </a>
                            <div style="float: right">
                                <a class="addthis_button_email"></a>
                                <a class="addthis_button_compact"></a>
                                <a class="addthis_counter addthis_bubble_style"></a>
                            </div>
                        </div>
                        <script type="text/javascript"> var addthis_share = {
                                url_transforms : {
                                    shorten: {
                                        twitter: 'bitly',
                                        facebook: 'bitly'
                                    }
                                },
                                shorteners : {
                                    bitly : {}
                                }
                            };
                            var addthis_config = { data_track_clickback: false };
                        </script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=kevincaldwell"></script>
                        <!-- AddThis Button END -->
                    </div>
                    <div class="list_expires crumbs" style="display: none;">
                        expires: <?= ($listing['listing_expires'] ? date('d-m-Y', strtotime($listing['listing_expires'])) : 'Unknown'); ?>
                    </div>
                    <div class="list_tags crumbs">
                        tags:
                        <?php $count = 0; foreach ($listing['listing_tags'] as $tag) { $count++; ?><?php echo ($count == '1' ? '' : ', '); ?><a href="/<?php echo $tag['tag_slug']; ?>/"><?php echo $tag['tag_name']; ?></a><?php } ?>
                        <?php if (empty($listing['listing_tags'])) echo 'None'; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap">
            <div class="left">
                <!-- Listing Skyscraper -->
                <ins class="adsbygoogle"
                     style="float:left; display:inline-block;width:230px;height:600px"
                     data-ad-client="ca-pub-5239608422081333"
                     data-ad-slot="8847693902"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="right">
                <?= $related_listings_html; ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php echo $footer; ?>