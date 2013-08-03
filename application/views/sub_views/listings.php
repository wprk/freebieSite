<div class="left">
    <?php if(isset($category) && $category['category_slug'] == "latest") { ?>
        <h1 class="section_normal">latest freebies</h1>
    <?php } else { ?>
        <a href="/" class="title_big">latest freebies</a>
    <?php } ?>
    <?php foreach($categories as $cat) { ?>
        <?php if(isset($category) && $category['category_slug'] == $cat['category_slug']) { ?>
            <h1 class="section_normal"><?php echo $cat['category_name'];?></h1>
        <?php } else { ?>
            <a href="/<?php echo $cat['category_slug'];?>/" class="title_big"><?php echo $cat['category_name'];?></a>
        <?php } ?>
    <?php } ?>
</div>

<div class="right">
    <?php $listing_count = 0; foreach($listings as $listing) {
        $listing_count++; ?>
        <div class="listing" itemscope itemtype="http://schema.org/Product">
            <div class="list_img">
                <img itemprop="image" src="/includes/images/listings/<?php echo $listing['listing_id'];?>.png" width="115" height="115" alt="<?php echo $listing['listing_title'];?>">
            </div>
            <div class="list_title">
                <a href="<?php echo str_replace('&', '&amp;', $listing['listing_url']); ?>" class="external title" itemprop="url">
                    <span itemprop="name"><?php echo $listing['listing_title'];?></span>
                </a>
                <?php echo (strlen($listing['listing_tracking_img']) > 0 ? '<img src="'.$listing['listing_tracking_img'].'" width="1" height="1" style="float:right;" />' : '') ; ?>
            </div>
            <div class="list_desc expired" itemprop="description">
                <?php echo $listing['listing_desc'];?>
            </div>
            <div class="list_expires crumbs">
                Expires: <?php echo ($listing['listing_expires'] ? date('d-m-Y', strtotime($listing['listing_expires'])) : 'Unknown'); ?>
            </div>
            <div class="list_tags crumbs">
                Tags:
                <?php $count = 0; foreach ($listing['listing_tags'] as $tag) { $count++; ?><?php echo ($count == '1' ? '' : ', '); ?><a href="/<?php echo $tag['tag_slug']; ?>/"><?php echo $tag['tag_name']; ?></a><?php } ?>
                <?php if (empty($listing['listing_tags'])) echo 'None'; ?>
            </div>
        </div>
        <?php if( (!($listing_count%3) && ($listing_count <= 9)) || ( (count($listings) <= 2) && ($listing_count == count($listings)) ) ) { ?>
            <div class="googlead">
            <script type="text/javascript"><!--
                google_ad_client = "ca-pub-5239608422081333";
                /* Listings */
                google_ad_slot = "3948177429";
                google_ad_width = 728;
                google_ad_height = 90;
                //-->
            </script>
            <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="backtotop">
        <span class="title_big">^</span> <a href="#top" class="title_big">back to the top</a>
    </div>
</div>
<div class="clear"></div>