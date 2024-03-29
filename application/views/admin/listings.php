<article class="module width_full">
    <header><h3 class="tabs_involved">All Listings</h3>
        <ul class="tabs">
            <li><a href="#listings">All Listings</a></li>
        </ul>
        <select id="listings_changer" onchange="">
            <option value="listings">All Listings</option>
            <?php foreach($categories as $category) { ?>
                <option value="<?php echo $category['category_slug'];?>"><?php echo $category['category_name']; ?></option>
            <?php } ?>
        </select>
    </header>

    <div class="tab_container">
        <div id="listings" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th>Listing Title</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Affiliate</th>
                    <th>Last Edited On</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($listings as $listing) { ?>
                <tr class="listings <?php echo $listing['category_slug'];?>">
                    <td>
                        <a href="/s5k9d7f6jdn0/listings/edit/<?php echo $listing['listing_id'];?>">
                            <?php echo $listing['listing_title'];?>
                        </a>
                    </td>
                    <td><?php echo $listing['category_name'];?></td>
                    <td><?php echo ($listing['listing_featured'] ? 'Y' : 'N');?></td>
                    <td><?php echo ($listing['listing_affiliate'] ? 'Y' : 'N');?></td>
                    <td><?php echo date("Y-m-d H:i:s", strtotime($listing['listing_created']));?></td>
                    <td><?php echo ($listing['listing_status'] == 1 ? 'Published' : ($listing['listing_status'] == 2 ? 'Expired' : 'Draft'));?></td>
                    <td>
                        <a href="/s5k9d7f6jdn0/listings/images/<?php echo $listing['listing_id'];?>">
                            <img class="images_icon" src="/includes/adm_images/icn_photo.png" title="Images" />
                        </a>
                        <a href="/s5k9d7f6jdn0/listings/edit/<?php echo $listing['listing_id'];?>">
                            <img class="edit_icon" src="/includes/adm_images/icn_edit.png" title="Edit" />
                        </a>
                        <a class="delete_action" href="/s5k9d7f6jdn0/listings/delete/<?php echo $listing['listing_id'];?>">
                            <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                        </a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- end of #listings -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of listing manager article -->