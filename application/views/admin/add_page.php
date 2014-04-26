<article class="module width_full">
    <header><h3>Add New Page</h3></header>
    <form action="/s5k9d7f6jdn0/pages/add/" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Page Name</label>
            <input id="page_name" name="page_name" type="text" placeholder="eg. Latest Freebies"/>
        </fieldset>
        <fieldset>
            <label>Page Slug</label>
            <input id="page_slug" name="page_slug" type="text" placeholder="eg. latest-freebies"/>
        </fieldset>
        <fieldset>
            <label>Page Tags</label>
            <select id="page_tags" name="page_tags[]" class="chosen-select" multiple="" data-placeholder="Add Tags to Listing...">
                <?php foreach ($tags as $tag) { ?>
                    <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" value="1" name="add_tags">
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <input type="submit" value="Add" class="alt_btn">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new page -->