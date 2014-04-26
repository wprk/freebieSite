<article class="module width_full">
    <header><h3>Edit Tag</h3></header>
    <form action="" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Tag Name</label>
            <input id="tag_name" name="tag_name" type="text" value="<?php echo $tag_record->tag_name; ?>" placeholder="eg. Free Stuff"/>
        </fieldset>
        <fieldset>
            <label>Tag Slug</label>
            <input id="tag_slug" name="tag_slug" type="text" value="<?php echo $tag_record->tag_slug; ?>" placeholder="eg. free-stuff"/>
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
<!-- end of post new tag -->