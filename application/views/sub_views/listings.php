<div class="left">
    <?php if(isset($category) && $category['category_slug'] == "latest") { ?>
        <h1 class="section_normal">latest freebies</h1>
    <?php } else { ?>
        <a href="<?= site_url('/'); ?>" class="title_big">latest freebies</a>
    <?php } ?>
    <?php foreach($categories as $cat) { ?>
        <?php if(isset($category) && $category['category_slug'] == $cat['category_slug']) { ?>
            <h1 class="section_normal"><?php echo $cat['category_name'];?></h1>
        <?php } else { ?>
            <a href="<?= site_url('/'.$cat['category_slug'].'/'); ?>" class="title_big"><?php echo $cat['category_name'];?></a>
        <?php } ?>
    <?php } ?>
</div>

<div class="right">
    <?php $listing_count = 0; foreach($listings as $listing) {
        $listing_count++; ?>
        <div class="listing" itemscope itemtype="http://schema.org/Product">
            <div class="list_img">
                <a href="<?= $listing['listing_url']; ?>" target="_blank">
                    <img itemprop="image" class="img-rounded" src="<?= site_url('/includes/images/listings/'.$listing['img_url']); ?>" width="115" height="115" alt="<?php echo $listing['listing_title'];?>">
                </a>
            </div>
            <div class="list_title">
                <a href="<?= site_url('/'.$listing['category_slug'].'/'.$listing['listing_uri']); ?>" class="external title" itemprop="url">
                    <span itemprop="name"><?php echo $listing['listing_title'];?></span>
                </a>
                <?php echo (strlen($listing['listing_tracking_img']) > 0 ? '<img src="'.site_url($listing['listing_tracking_img']).'" width="1" height="1" style="float:right;" />' : '') ; ?>
                <a href="<?= $listing['listing_url']; ?>" target="_blank" class="btn listing_btn btn-danger btn-xs pull-right crumbs">get freebie</a>
            </div>
            <div class="list_desc expired" itemprop="description">
                <?= mb_strimwidth($listing['listing_desc'], 0, 230, '<a href="'.site_url('/'.$listing['category_slug'].'/'.$listing['listing_uri']).'">...</a>'); ?>
            </div>
            <div class="list_share crumbs">
                <!-- AddThis Button BEGIN -->
                <?php $server_img_path = realpath(BASEPATH . '../includes/images/listings/'.$listing['listing_uri'].'-lrg.png'); ?>
                <?php $media_link = site_url().(file_exists($server_img_path) ? '/includes/images/listings/'.$listing['listing_uri'].'-lrg.png' : '/includes/images/listings/'.$listing['img_url']); ?>
                <div class="addthis_toolbox addthis_default_style"
                     addthis:url="<?= site_url(); ?>/<?= $listing['category_slug']; ?>/<?= $listing['listing_uri']; ?>"
                     addthis:title="<?= $listing['listing_title']; ?>"
                     pi:pinit:media="<?=$media_link;?>"
                     addthis:description="<?= $listing['listing_desc']; ?>">
                    <span class="share">share:</span>
                    <a class="addthis_button_facebook"><img src="<?= site_url('/includes/images/share_icons/share-fb-logo.png'); ?>" width="16" height="16"><span class="share-label">facebook</span></a>
                    <a class="addthis_button_twitter" addthis:title="<?= $listing['listing_title']; ?>"><img src="<?= site_url('/includes/images/share_icons/share-tw-logo.png'); ?>" width="16" height="16"><span class="share-label">twitter</span></a>
                    <a class="addthis_button_google_plusone_share"><img src="<?= site_url('/includes/images/share_icons/share-gp-logo.png'); ?>" width="16" height="16"><span class="share-label">google+</span></a>
                    <a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=http://<?= $site['site_url']; ?>/<?= $listing['listing_uri']; ?>&media=<?=$media_link;?>&description=<?= urlencode($listing['listing_title']); ?>%20-%20<?= urlencode($listing['listing_desc']); ?>" data-pin-do="buttonPin" data-pin-config="above">
                       <img src="<?= site_url('/includes/images/share_icons/share-pn-logo.png'); ?>" width="16" height="16"><span class="share-label">pinterest</span>
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
                <?php $count = 0; foreach ($listing['listing_tags'] as $tag) { $count++; ?><?php echo ($count == '1' ? '' : ', '); ?><a href="<?= site_url('/'.$tag['tag_slug'].'/'); ?>"><?php echo $tag['tag_name']; ?></a><?php } ?>
                <?php if (empty($listing['listing_tags'])) echo 'None'; ?>
            </div>
        </div>
        <?php if( (!($listing_count%3) && ($listing_count <= 9)) || ( (count($listings) <= 2) && ($listing_count == count($listings)) ) ) { ?>
            <div class="googlead">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-5239608422081333"
                     data-ad-slot="1389877043"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="backtotop">
        <span class="title_big">^</span> <a href="#top" class="title_big">back to the top</a>
    </div>
</div>
<div class="clear"></div>