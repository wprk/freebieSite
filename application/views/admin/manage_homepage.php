<article class="module width_full">
    <header><h3>Chosen Listings</h3></header>
    <div class="module_content">
        <fieldset>
            <label>Chosen Listings</label>
            <form action="/s5k9d7f6jdn0/ajax/update_homepage/" id="update_homepage" method="post">
                <select id="chosen_listings" name="chosen_listings[]" class="chosen-select" multiple="" data-placeholder="Add Listings to Homepage...">
                    <?php foreach ($affiliate_listings as $listing) { ?>
                        <option <?= (in_array($listing['listing_id'], array_map(
                            create_function('$value', 'return $value["listing_id"];'),
                            $chosen_listings
                        )) ? 'selected="selected"' : '') ?> value="<?php echo $listing['listing_id']; ?>"><?php echo $listing['listing_title']; ?></option>
                    <?php } ?>
                </select>
            </form>
        </fieldset>

        <div class="clear"></div>
    </div>
</article>
<article class="module width_full">
    <header><h3>Change Order</h3></header>
        <div class="module_content">
            <div id="chosen_listing_container">
            <?php foreach ($chosen_listings as $listing) { ?>
                <div class="chosen_listing" data-listing-id="<?= $listing['listing_id']; ?>"><?= $listing['listing_title']; ?></div>
            <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</article>
<!-- end of post new listing -->
