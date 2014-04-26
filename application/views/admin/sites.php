<article class="module width_full">
    <header><h3 class="tabs_involved">All Sites</h3>
        <ul class="tabs">
            <li><a href="#tags">Sites</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="pages" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th>Site Name</th>
                    <th>Site Url</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sites as $site) { ?>
                    <tr>
                        <td>
                            <a href="/s5k9d7f6jdn0/sites/edit/<?php echo $site['site_id'];?>">
                                <?php echo $site['site_name']; ?>
                            </a>
                        </td>
                        <td><?php echo $site['site_url']; ?></td>
                        <td>
                            <a href="/s5k9d7f6jdn0/sites/edit/<?php echo $site['site_id'];?>">
                                <input type="image" src="/includes/adm_images/icn_edit.png" title="Edit">
                            </a>
                            <a class="delete_action" href="/s5k9d7f6jdn0/sites/delete/<?php echo $site['site_id'];?>">
                                <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <!-- end of #sites -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of page manager article -->