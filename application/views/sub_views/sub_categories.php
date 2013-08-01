<div id="sub_categories">
    <div class="wrap">
        <div class="right">
            <?php if ($sub_categories) { ?>
                <?php $i = 0; $sub_category_count = count($sub_categories); foreach($sub_categories as $subcat) { $i++ ?>
                        <a class="crumbs_blk" href="/<?php echo $category['category_slug'];?>/<?php echo $subcat['sub_category_slug'];?>">
                            <?php echo $subcat['sub_category_name'];?>
                        </a>
                    <?php if($i < $sub_category_count) { ?>
                        |
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="left">
            <!-- AddThis Button BEGIN -->
        </div>
    </div>
</div>