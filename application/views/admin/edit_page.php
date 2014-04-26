<article class="module width_full">
    <header><h3>Edit Page</h3></header>
    <form action="" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Page Name</label>
            <input id="page_name" name="page_name" type="text" value="<?php echo $page_record->page_name; ?>" placeholder="eg. Free Stuff"/>
        </fieldset>
        <fieldset>
            <label>Page Slug</label>
            <input id="page_slug" name="page_slug" type="text" value="<?php echo $page_record->page_slug; ?>" placeholder="eg. free-stuff"/>
        </fieldset>
        <fieldset>
            <label>Page Tags</label>
            <select id="page_tags" name="page_tags[]" class="chosen-select" multiple="" data-placeholder="Add Tags to Listing...">
                <?php foreach ($tags as $tag) { ?>
                    <option<?php echo (in_array($tag['tag_id'], $page_record->tag_ids) ? ' selected="selected"' : '') ?>  value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" value="1" name="add_tags">
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <input name="submitted" type="submit" value="Update" class="alt_btn">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new page -->