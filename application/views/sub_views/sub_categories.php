<div id="sub_categories">
    <div class="wrap">
        <div class="right">
            <?php if (isset($sub_categories) || isset($more_tags)) { ?>
                <?php if (isset($sub_categories)) { ?>
                    <?php $i = 0; $sub_category_count = count($sub_categories); foreach($sub_categories as $subcat) { $i++ ?>
                        <?php if ($sub_category_id == $subcat['sub_category_id']) { ?>
                            <h1 class="crumbs_blk current">
                                <?php echo $subcat['sub_category_name'];?>
                            </h1>
                        <?php } else { ?>
                            <a class="crumbs_blk" href="/<?php echo $category['category_slug'];?>/<?php echo $subcat['sub_category_slug'];?>">
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
                        <a class="crumbs_blk" href="/<?php echo $xtag['tag_slug'];?>">
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
            <?php } ?>
        </div>
        <div class="left">
            <!-- AddThis Button BEGIN -->
        </div>
    </div>
</div>