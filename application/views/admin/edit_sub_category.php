<article class="module width_full">
    <header><h3>Add New Sub Category</h3></header>
    <form action="/s5k9d7f6jdn0/categories/editsub/<?= $sub_category_record->sub_category_id; ?>" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Parent Category</label>
            <select id="category_id" name="category_id">
                <option value="">Add Parent Category</option>
                <?php foreach ($categories as $category) { ?>
                    <option<?= ($sub_category_record->category_id == $category['category_id'] ? ' selected="selected"' : '') ?> value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php } ?>
            </select>
        </fieldset>
        <fieldset>
            <label>Sub Category Name</label>
            <input id="sub_category_name" name="sub_category_name" type="text" placeholder="eg. Chocolate" value="<?= ($sub_category_record ? $sub_category_record->sub_category_name : '') ?>"/>
        </fieldset>
        <fieldset>
            <label>Sub Category Slug</label>
            <input id="sub_category_slug" name="sub_category_slug" type="text" placeholder="eg. yummy-chocolate" value="<?= ($sub_category_record ? $sub_category_record->sub_category_slug : '') ?>"/>
        </fieldset>
        <fieldset>
            <label>Sub Category Description</label>
            <textarea id="sub_category_desc" name="sub_category_desc" rows="4"><?= ($sub_category_record ? $sub_category_record->sub_category_desc : '') ?></textarea>
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
<!-- end of post new category -->
