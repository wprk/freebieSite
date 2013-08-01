<article class="module width_full">
    <header><h3>Edit Listing</h3></header>
    <form action="" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Listing Title</label>
            <input id="listing_title" name="listing_title" value="<?php echo $listing_record->listing_title; ?>" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Slug</label>
            <input id="listing_uri" name="listing_uri" value="<?php echo $listing_record->listing_uri; ?>" type="text">
        </fieldset>
        <fieldset>
            <label>Listing URL</label>
            <input id="listing_url" name="listing_url" value="<?php echo $listing_record->listing_url; ?>" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Tracking Image</label>
            <input id="listing_tracking_img" name="listing_tracking_img" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Affiliate</label>
            <input id="listing_affiliate" name="listing_affiliate" value="1" type="checkbox" value="1"<?php echo ($listing_record->listing_affiliate == 1 ? ' checked="checked"' : '') ?> style="float: left; clear: left; margin: 0 0 0 10px;">
        </fieldset>
        <fieldset>
            <label>Listing Featured</label>
            <input id="listing_featured" name="listing_featured" value="1" type="checkbox" value="1"<?php echo ($listing_record->listing_featured == 1 ? ' checked="checked"' : '') ?> style="float: left; clear: left; margin: 0 0 0 10px;">
        </fieldset>
        <fieldset>
            <label>Deafult Listing Description</label>
            <textarea id="listing_desc" name="listing_desc" rows="4"><?php echo $listing_record->listing_desc; ?></textarea>
        </fieldset>
        <fieldset>
            <label>Alternative Listing Description</label>
            <textarea class="listing_alt_desc" id="listing_alt_desc" name="listing_alt_desc" rows="4"><?php echo $listing_record->listing_alt_desc; ?></textarea>
        </fieldset>
        <fieldset style="width:48%; float:left; margin-right: 3%;">
            <label>Category</label>
            <select id="listing_category_id" name="listing_category_id" class="chosen-select" style="width:92%;">
                <option vakue="">Add Category to Listing</option>
                <?php foreach ($categories as $category) { ?>
                    <option<?php echo ($listing_record->category_id == $category['category_id'] ? ' selected="selected"' : '') ?> value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select>
            <div style="height: 20px;"></div>
            <label>Sub Category</label>
            <select id="listing_sub_category_id" name="listing_sub_category_id" class="chosen-select" style="width:92%;">
                <option vakue="">Add Sub Category to Listing</option>
                <?php foreach($sub_categories as $sub_category) { ?>
                    <option<?php echo ($listing_record->sub_category_id == $sub_category['sub_category_id'] ? ' selected="selected"' : '') ?> value="<?php echo $sub_category['sub_category_id']; ?>"><?php echo $sub_category['sub_category_name']; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset style="width:48%; float:left;">
            <label>Tags</label>
            <select name="listing_tags[]" class="chosen-select" multiple="" style="width:92%;" data-placeholder="Add Tags to Listing...">
                <?php foreach ($tags as $tag) { ?>
                    <option<?php echo (in_array($tag['tag_id'], $listing_record->tag_ids) ? ' selected="selected"' : '') ?>  value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset style="width:48%; float:left;">
            <label>Expiry</label>
            <input class="datepicker" id="listing_expires" name="listing_expires" type="text" value="<?php echo ($listing_record->listing_expires != '' ? $listing_record->listing_expires : ''); ?>" style="width:92%;">
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <select id="listing_status" name="listing_status">
                <?php if( ($listing_record->listing_expired > date("Y-m-d H:i:s")) || ($listing_record->listing_status ==  2) ) { ?>
                    <option selected="selected" value="2">Archived</option>
                <?php } ?>
                <option<?php echo ($listing_record->listing_status == 0 ? ' selected="selected"' : '') ?> value="0">Draft</option>
                <option<?php echo ($listing_record->listing_status == 1 ? ' selected="selected"' : '') ?> value="1">Published</option>
            </select>
            <input name="submitted" type="submit" value="Update" class="alt_btn">
            <input type="submit" value="Reset">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new article -->
