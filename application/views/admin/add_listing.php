<article class="module width_full">
    <header><h3>Add New Listing</h3></header>
    <form action="/admin/add/listings/" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Listing Title</label>
            <input id="listing_title" name="listing_title" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Slug</label>
            <input id="listing_uri" name="listing_uri" type="text">
        </fieldset>
        <fieldset>
            <label>Listing URL</label>
            <input id="listing_url" name="listing_url" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Tracking Image</label>
            <input id="listing_tracking_img" name="listing_tracking_img" type="text">
        </fieldset>
        <fieldset>
            <label>Listing Affiliate</label>
            <input id="listing_affiliate" name="listing_affiliate" value="1" type="checkbox" value="1" style="float: left; clear: left; margin: 0 0 0 10px;">
        </fieldset>
        <fieldset>
            <label>Listing Featured</label>
            <input id="listing_featured" name="listing_featured" value="1" type="checkbox" value="1" style="float: left; clear: left; margin: 0 0 0 10px;">
        </fieldset>
        <fieldset>
            <label>Deafult Listing Description</label>
            <textarea id="listing_desc" name="listing_desc" rows="4"></textarea>
        </fieldset>
        <fieldset>
            <label>Alternative Listing Description</label>
            <textarea class="listing_alt_desc" id="listing_alt_desc" name="listing_alt_desc" rows="4"></textarea>
        </fieldset>
        <fieldset style="width:48%; float:left; margin-right: 3%;">
            <label>Category</label>
            <select id="listing_category_id" name="listing_category_id" style="width:92%;">
                <option value="0">Select a Category</option>
                <?php foreach($categories as $category) { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select>
            <div style="height: 20px;"></div>
            <label>Sub Category</label>
            <select id="listing_sub_category_id" name="listing_sub_category_id" style="width:92%;">
                <option value="0">Select a Sub Category</option>
                <?php foreach($sub_categories as $sub_category) { ?>
                    <option<?php echo ($listing_record->sub_category_id == $sub_category['sub_category_id'] ? ' selected="selected"' : '') ?> value="<?php echo $sub_category['sub_category_id']; ?>"><?php echo $sub_category['sub_category_name']; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset style="width:48%; float:left;">
            <label>Tags</label>
            <input id="listing_tags" name="listing_tags" type="text" style="width:92%;">
        </fieldset>
        <fieldset style="width:48%; float:left;">
            <label>Expiry</label>
            <input class="datepicker" id="listing_expires" name="listing_expires" type="text" style="width:92%;">
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <select id="listing_status" name="listing_status">
                <option value="0">Draft</option>
                <option selected="selected" value="1">Published</option>
            </select>
            <input type="submit" value="Add" class="alt_btn">
            <input type="submit" value="Reset">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new article -->