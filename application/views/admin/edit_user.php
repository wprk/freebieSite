<article class="module width_full">
    <header><h3>Edit User</h3></header>
    <form action="" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Full Name</label>
            <input id="fullname" name="fullname" type="text" value="<?php echo $user_record->fullname; ?>" placeholder="eg. Joe Bloggs"/>
        </fieldset>
        <fieldset>
            <label>Username</label>
            <input id="username" name="username" type="text" value="<?php echo $user_record->username; ?>" placeholder="eg. myusername"/>
        </fieldset>
        <fieldset>
            <label>Email</label>
            <input id="email" name="email" type="text" value="<?php echo $user_record->email; ?>" placeholder="eg. myemail@domain.com"/>
        </fieldset>
        <fieldset>
            <label>Password</label>
            <input id="password" name="password" type="password" placeholder="eg. X8df!90EO"/>
        </fieldset>
        <fieldset>
            <label>Password Confirmation</label>
            <input id="passwordconf" name="passwordconf" type="password" placeholder="eg. X8df!90EO"/>
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <input name="submitted" type="submit" value="Update" class="alt_btn">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new article -->