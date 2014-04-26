<article class="module width_full">
    <header><h3>Edit Site</h3></header>
    <form action="" autocomplete="on" method="post">
        <div class="module_content">
            <fieldset>
                <label>Site Name</label>
                <input id="site_name" name="site_name" type="text" value="<?= $site_record->site_name; ?>" placeholder="eg. Example Co"/>
            </fieldset>
            <fieldset>
                <label>Site Url</label>
                <input id="site_url" name="site_url" type="text" value="<?= $site_record->site_url; ?>" placeholder="eg. example.co.uk" />
            </fieldset>
            <fieldset>
                <label>Site Summary</label>
                <textarea id="site_summary" name="site_summary" rows="4"><?= $site_record->site_summary; ?></textarea>
            </fieldset>
            <fieldset>
                <label>Google Analytics ID</label>
                <input id="google_analytics" name="google_analytics" type="text" value="<?= $site_record->google_analytics; ?>" placeholder="eg. UA-16556605-3" />
            </fieldset>
            <fieldset>
                <label>Twitter Handle</label>
                <input id="twitter_handle" name="twitter_handle" type="text" value="<?= $site_record->twitter_handle; ?>" placeholder="eg. all4freeuk" />
            </fieldset>
            <fieldset>
                <label>Facebook ID</label>
                <input id="facebook_handle" name="facebook_handle" type="text" value="<?= $site_record->facebook_handle; ?>" placeholder="eg. all4freeuk" />
            </fieldset>
            <div class="clear"></div>
        </div>
        <footer>
            <div class="submit_link">
                <input type="submit" value="Update" class="alt_btn">
            </div>
        </footer>
    </form>
</article>
<!-- end of edit site -->