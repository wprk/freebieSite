<article class="module width_full">
    <header><h3 class="tabs_involved">All Pages</h3>
        <ul class="tabs">
            <li><a href="#tags">Pages</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="pages" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th>Page Name</th>
                    <th>Page Slug</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pages as $page) { ?>
                    <tr>
                        <td>
                            <a href="/s5k9d7f6jdn0/pages/edit/<?php echo $page['page_id'];?>">
                                <?php echo $page['page_name']; ?>
                            </a>
                        </td>
                        <td><?php echo $page['page_slug']; ?></td>
                        <td>
                            <a href="/s5k9d7f6jdn0/pages/edit/<?php echo $page['page_id'];?>">
                                <input type="image" src="/includes/adm_images/icn_edit.png" title="Edit">
                            </a>
                            <a class="delete_action" href="/s5k9d7f6jdn0/pages/delete/<?php echo $page['page_id'];?>">
                                <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <!-- end of #pages -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of page manager article -->