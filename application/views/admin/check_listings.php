<article class="module width_full">
    <header><h3 class="tabs_involved">Check Listings</h3>
        <ul class="tabs">
            <li><a href="#expired">Expired Listings</a></li>
            <li><a href="#oldest">Oldest Listings</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="expired" class="tab_content">
            <?php if($expired) { ?>
                <iframe class="check_listing_iframe" frameborder="0" src="<?php echo $expired['listing_url']; ?>"></iframe>
                <footer>
                    <div class="submit_link">
                        <form action="/s5k9d7f6jdn0/listings/edit/<?php echo $expired['listing_id']; ?>/" autocomplete="on" method="post">
                            <input class="datepicker" id="listing_expires" name="listing_expires" type="text" value="<?php echo ($expired['listing_expires'] != '' ? $expired['listing_expires'] : ''); ?>" size="8" style="text-align: center;">
                            <input name="listing_title" value="<?php echo $expired['listing_title']; ?>" type="hidden">
                            <input name="listing_alt_title" value="<?php echo $expired['listing_alt_title']; ?>" type="hidden">                            <input name="listing_uri" value="<?php echo $oldest['listing_uri']; ?>" type="hidden">
                            <input name="listing_url" value="<?php echo $expired['listing_url']; ?>" type="hidden">
                            <input name="listing_desc" value="<?php echo $expired['listing_desc']; ?>" type="hidden">
                            <input name="listing_alt_desc" value="<?php echo $expired['listing_alt_desc']; ?>" type="hidden">
                            <input name="listing_category_id" value="<?php echo $expired['category_id']; ?>" type="hidden">
                            <input name="listing_sub_category_id" value="<?php echo $expired['sub_category_id']; ?>" type="hidden">
                            <input name="listing_status" value="<?php echo $expired['listing_status']; ?>" type="hidden">
                            <input name="return_url" value="/s5k9d7f6jdn0/listings/check/#expired" type="hidden">
                            <input type="submit" name="submitted" value="Extend" class="alt_btn">
                        </form>
                        <a href="/s5k9d7f6jdn0/listings/edit/<?php echo $expired['listing_id'];?>">
                            <input type="submit" value="Edit" class="alt_btn">
                        </a>
                        <form action="/s5k9d7f6jdn0/listings/edit/<?php echo $expired['listing_id']; ?>/" autocomplete="on" method="post">
                            <input name="listing_title" value="<?php echo $expired['listing_title']; ?>" type="hidden">
                            <input name="listing_alt_title" value="<?php echo $expired['listing_alt_title']; ?>" type="hidden">                            <input name="listing_uri" value="<?php echo $expired['listing_uri']; ?>" type="hidden">
                            <input name="listing_url" value="<?php echo $expired['listing_url']; ?>" type="hidden">
                            <input name="listing_desc" value="<?php echo $expired['listing_desc']; ?>" type="hidden">
                            <input name="listing_alt_desc" value="<?php echo $expired['listing_alt_desc']; ?>" type="hidden">
                            <input name="listing_category_id" value="<?php echo $expired['category_id']; ?>" type="hidden">
                            <input name="listing_sub_category_id" value="<?php echo $expired['sub_category_id']; ?>" type="hidden">
                            <input name="listing_expires" value="<?php echo $expired['listing_expires']; ?>" type="hidden">
                            <input name="listing_status" value="2" type="hidden">
                            <input name="return_url" value="/s5k9d7f6jdn0/listings/check/#expired" type="hidden">
                            <input type="submit" name="submitted" value="Archive">
                        </form>
                        <a class="delete_action" href="/s5k9d7f6jdn0/action/listing/delete/<?php echo $expired['listing_id'];?>">
                            <input type="submit" value="Delete">
                        </a>
                    </div>
                    <div class="goto_link">
                        <a href="<?php echo $expired['listing_url']; ?>" target="_blank">
                            <input type="submit" value="Open in New Window" class="alt_btn">
                        </a>
                    </div>
                </footer>
            <?php } else { ?>
                <p style="padding-left: 20px;">You have no listings past their expiry date.</p>
            <?php } ?>
        </div>
        <!-- end of #expired -->

        <div id="oldest" class="tab_content">
            <iframe class="check_listing_iframe" frameborder="0" src="<?php echo $oldest['listing_url']; ?>"></iframe>
            <footer>
                <div class="submit_link">
                    <form action="/s5k9d7f6jdn0/listings/edit/<?php echo $oldest['listing_id']; ?>/" autocomplete="on" method="post">
                        <input name="listing_title" value="<?php echo $oldest['listing_title']; ?>" type="hidden">
                        <input name="listing_alt_title" value="<?php echo $oldest['listing_alt_title']; ?>" type="hidden">                        <input name="listing_uri" value="<?php echo $oldest['listing_uri']; ?>" type="hidden">
                        <input name="listing_url" value="<?php echo $oldest['listing_url']; ?>" type="hidden">
                        <input name="listing_desc" value="<?php echo $oldest['listing_desc']; ?>" type="hidden">
                        <input name="listing_alt_desc" value="<?php echo $oldest['listing_alt_desc']; ?>" type="hidden">
                        <input name="listing_category_id" value="<?php echo $oldest['category_id']; ?>" type="hidden">
                        <input name="listing_sub_category_id" value="<?php echo $oldest['sub_category_id']; ?>" type="hidden">
                        <input name="listing_expires" value="<?php echo $oldest['listing_expires']; ?>" type="hidden">
                        <input name="listing_status" value="<?php echo $oldest['listing_status']; ?>" type="hidden">
                        <input name="return_url" value="/s5k9d7f6jdn0/listings/check/#oldest" type="hidden">
                        <input type="submit" name="submitted" value="Approve" class="alt_btn">
                    </form>
                    <a href="/s5k9d7f6jdn0/listings/edit/<?php echo $oldest['listing_id'];?>">
                        <input type="submit" value="Edit" class="alt_btn">
                    </a>
                    <form action="/s5k9d7f6jdn0/listings/edit/<?php echo $oldest['listing_id']; ?>/" autocomplete="on" method="post">
                        <input name="listing_title" value="<?php echo $oldest['listing_title']; ?>" type="hidden">
                        <input name="listing_alt_title" value="<?php echo $oldest['listing_alt_title']; ?>" type="hidden">
                        <input name="listing_uri" value="<?php echo $oldest['listing_uri']; ?>" type="hidden">
                        <input name="listing_url" value="<?php echo $oldest['listing_url']; ?>" type="hidden">
                        <input name="listing_desc" value="<?php echo $oldest['listing_desc']; ?>" type="hidden">
                        <input name="listing_alt_desc" value="<?php echo $oldest['listing_alt_desc']; ?>" type="hidden">
                        <input name="listing_category_id" value="<?php echo $oldest['category_id']; ?>" type="hidden">
                        <input name="listing_sub_category_id" value="<?php echo $oldest['sub_category_id']; ?>" type="hidden">
                        <input name="listing_expires" value="<?php echo $oldest['listing_expires']; ?>" type="hidden">
                        <input name="listing_status" value="2" type="hidden">
                        <input name="return_url" value="/s5k9d7f6jdn0/listings/check/#oldest" type="hidden">
                        <input type="submit" name="submitted" value="Archive">
                    </form>
                    <a class="delete_action" href="/s5k9d7f6jdn0/listing/delete/<?php echo $oldest['listing_id'];?>">
                        <input type="submit" value="Delete">
                    </a>
                </div>
                <div class="goto_link">
                    <a href="<?php echo $oldest['listing_url']; ?>" target="_blank">
                        <input type="submit" value="Open in New Window" class="alt_btn">
                    </a>
                </div>
            </footer>
        </div>
        <!-- end of #oldest -->

    </div>

</article>
<!-- end of check listing manager -->