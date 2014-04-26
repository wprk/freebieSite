<article class="module width_full">
    <header><h3 class="tabs_involved">All Tags</h3>
        <ul class="tabs">
            <li><a href="#tags">Tags</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="tags" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th>Tag Name</th>
                    <th>Tag Slug</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($tags as $tag) { ?>
                    <tr>
                        <td>
                            <a href="/s5k9d7f6jdn0/tags/edit/<?php echo $tag['tag_id'];?>">
                                <?php echo $tag['tag_name']; ?>
                            </a>
                        </td>
                        <td><?php echo $tag['tag_slug']; ?></td>
                        <td>
                            <a href="/s5k9d7f6jdn0/tags/edit/<?php echo $tag['tag_id'];?>">
                                <input type="image" src="/includes/adm_images/icn_edit.png" title="Edit">
                            </a>
                            <a class="delete_action" href="/s5k9d7f6jdn0/tags/delete/<?php echo $tag['tag_id'];?>">
                                <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <!-- end of #tags -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of tag manager article -->