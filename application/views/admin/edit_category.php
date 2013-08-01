<article class="module width_full">
    <header><h3>Edit Category</h3></header>
    <form action="" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Category Name</label>
            <input id="category_name" name="category_name" type="text" value="<?php echo $category_record->category_name; ?>" placeholder="eg. Books & Magazines"/>
        </fieldset>
        <fieldset>
            <label>Category Slug</label>
            <input id="category_slug" name="category_slug" type="text" value="<?php echo $category_record->category_slug; ?>" placeholder="eg. books-and-magazines"/>
        </fieldset>
        <fieldset>
            <label>Category Description</label>
            <textarea id="category_desc" name="category_desc" rows="4"><?php echo $category_record->category_desc; ?></textarea>
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <input name="submitted" type="submit" value="Update" class="alt_btn">
            <input type="submit" value="Reset">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new category -->