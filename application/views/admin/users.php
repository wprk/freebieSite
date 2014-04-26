<article class="module width_full">
    <header><h3 class="tabs_involved">All Users</h3>
        <ul class="tabs">
            <li><a href="#users">Users</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="users" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user) { ?>
                    <tr>
                        <td>
                            <a href="/s5k9d7f6jdn0/users/edit/<?php echo $user['id'];?>">
                                <?php echo $user['fullname']; ?>
                            </a>
                        </td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="/s5k9d7f6jdn0/users/edit/<?php echo $user['id'];?>">
                                <img class="edit_icon" src="/includes/adm_images/icn_edit.png" title="Edit" />
                            </a>
                            <a class="delete_action" href="/s5k9d7f6jdn0/users/delete/<?php echo $user['id'];?>">
                                <img class="delete_icon" src="/includes/adm_images/icn_trash.png" title="Trash" />
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
        <!-- end of #users -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of listing manager article -->