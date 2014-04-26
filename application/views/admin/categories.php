<article class="module width_full">
    <header><h3 class="tabs_involved">All Categories</h3>
        <ul class="tabs">
            <li><a href="#users">Categories</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="users" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2">Category Name</th>
                    <th>Category Slug</th>
                    <th>Category Desc</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($categories as $cat) { ?>
                    <tr>
                        <td colspan="2">
                            <a href="/s5k9d7f6jdn0/categories/edit/<?php echo $cat['category_id'];?>">
                                <?php echo $cat['category_name']; ?>
                            </a>
                        </td>
                        <td><?php echo $cat['category_slug']; ?></td>
                        <td><?php echo $cat['category_desc']; ?></td>
                        <td>
                            <a href="/s5k9d7f6jdn0/categories/edit/<?php echo $cat['category_id'];?>">
                                <input type="image" src="/includes/adm_images/icn_edit.png" title="Edit">
                            </a>
                            <a class="delete_action" href="/s5k9d7f6jdn0/categories/delete/<?php echo $cat['category_id'];?>">
                                <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                            </a>
                        </td>
                    </tr>
                    <?php foreach($this->admin_model->get_sub_categories($cat['category_id']) as $cat) { ?>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <a href="/s5k9d7f6jdn0/categories/editsub/<?php echo $cat['sub_category_id'];?>">
                                    <?php echo $cat['sub_category_name']; ?>
                                </a>
                            </td>
                            <td><?php echo $cat['sub_category_slug']; ?></td>
                            <td><?php echo $cat['sub_category_desc']; ?></td>
                            <td>
                                <a href="/s5k9d7f6jdn0/categories/editsub/<?php echo $cat['sub_category_id'];?>">
                                    <input type="image" src="/includes/adm_images/icn_edit.png" title="Edit">
                                </a>
                                <a class="delete_action" href="/s5k9d7f6jdn0/categories/deletesub/<?php echo $cat['sub_category_id'];?>">
                                    <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <!-- end of #users -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of listing manager article -->