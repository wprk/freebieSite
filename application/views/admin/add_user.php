<article class="module width_full">
    <header><h3>Add New User</h3></header>
    <form action="/admin/add/users/" autocomplete="on" method="post">
    <div class="module_content">
        <fieldset>
            <label>Full Name</label>
            <input id="fullname" name="fullname" type="text" placeholder="eg. Joe Bloggs"/>
        </fieldset>
        <fieldset>
            <label>Username</label>
            <input id="username" name="username" type="text" placeholder="eg. myusername"/>
        </fieldset>
        <fieldset>
            <label>Email</label>
            <input id="email" name="email" type="text" placeholder="eg. myemail@domain.com"/>
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
            <input type="submit" value="Add" class="alt_btn">
            <input type="submit" value="Reset">
        </div>
    </footer>
    </form>
</article>
<!-- end of post new article -->