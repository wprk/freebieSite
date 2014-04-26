<div id="sub_categories">
    <div class="wrap">
        <div class="right">
            <?php if (isset($sub_categories) || isset($more_tags) || isset($more_pages)) { ?>
                <?php if (isset($sub_categories)) { ?>
                    <?php $i = 0; $sub_category_count = count($sub_categories); foreach($sub_categories as $subcat) { $i++ ?>
                        <?php if ($sub_category_id == $subcat['sub_category_id']) { ?>
                            <h1 class="crumbs_blk current">
                                <?php echo $subcat['sub_category_name'];?>
                            </h1>
                        <?php } else { ?>
                            <a class="crumbs_blk" href="/<?php echo $category['category_slug'];?>/<?php echo $subcat['sub_category_slug'];?>/">
                                <?php echo $subcat['sub_category_name'];?>
                            </a>
                        <?php } ?>
                        <?php if($i < $sub_category_count) { ?>
                            |
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($more_tags)) { ?>
                    <?php foreach($more_tags as $xtag) { ?>
                        <a class="crumbs_blk" href="/<?php echo $xtag['tag_slug'];?>/">
                            <?php echo $xtag['tag_name'];?>
                        </a>
                        |
                    <?php } ?>
                <?php } ?>
                <?php if (isset($tag)) { ?>
                    <h1 class="crumbs_blk current">
                        <?php echo $tag['tag_name'];?>
                    </h1>
                <?php } ?>
                <?php if (isset($more_pages)) { ?>
                    <?php $i = 0; $pages_count = count($more_pages); foreach($more_pages as $page) { $i++ ?>
                        <?php if ($page_id == $page['page_id']) { ?>
                            <h1 class="crumbs_blk current">
                                <?php echo $page['page_name'];?>
                            </h1>
                        <?php } else { ?>
                            <a class="crumbs_blk" href="/<?php echo $page['page_slug'];?>/">
                                <?php echo $page['page_name'];?>
                            </a>
                        <?php } ?>
                        <?php if($i < $pages_count) { ?>
                            |
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <?php if ( !isset($more_tags) && isset($sub_categories) && count($sub_categories) < 1 ) { ?>
                    <?php for($i == 1; $i < count($landing_pages); $i++) { ?>
                        <a class="crumbs_blk" href="/<?php echo $landing_pages[$i]['page_slug'];?>/">
                            <?php echo $landing_pages[$i]['page_name'];?>
                        </a>
                        <?php if($i < (count($landing_pages)-1)) { ?>
                            |
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="left">
            <!-- AddThis Button BEGIN -->
        </div>
    </div>
</div>