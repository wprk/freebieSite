<article class="module width_full">
    <header><h3>Update Listing Images</h3></header>
    <form action="" autocomplete="on" method="post" enctype="multipart/form-data">
        <div class="module_content">
            <fieldset>
                <label>Listing Title</label>
                <input id="listing_title" name="listing_title" disabled="disabled" value="<?= ($listing_record ? $listing_record->listing_title : '') ?>" type="text">
            </fieldset>

            <fieldset>
                <label>Small Listing Image</label>
                <div id="thumbnail-images">
                <?php foreach($listing_record->imgs as $img): ?>
                    <?php if ($img['img_size'] == '115x115') { ?>
                        <img src="/includes/images/listings/<?=$img['img_uri'].'.'.$img['img_ext']; ?>" />
                    <?php } ?>
                <?php endforeach ?>
                </div>
<!--                <input type="file" id="listing_sml_img" name="listing_sml_img" style="width:92%;" />-->

                <div style="clear:both; height: 20px;"></div>
                <label>Large Listing Image</label>
                <div id="large-images">
                    <?php foreach($listing_record->imgs as $img): ?>
                        <?php if ($img['img_size'] == '520x520') { ?>
                            <img src="/includes/images/listings/<?=$img['img_uri'].'.'.$img['img_ext']; ?>" />
                        <?php } ?>
                    <?php endforeach ?>
                </div>
                <input type="file" id="listing_lrg_img" name="listing_lrg_img" style="width:92%;" />
            </fieldset>

            <div class="clear"></div>
        </div>
        <footer>
            <div class="submit_link">
                <input name="submitted" type="submit" value="Update" class="alt_btn">
                <a href="/s5k9d7f6jdn0/listings/" class="alt_btn">Accept Images</a>
            </div>
        </footer>
    </form>
</article>
<!-- end of post listing images -->
