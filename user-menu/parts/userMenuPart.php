<div class="account-menu">
    <ul>
        <?php if ((int)$_SESSION['role'] === 1): ?>
            <li>
                <a href="/admin-menu/admin-panel">
                    <button class="button">Admin panel</button>
                </a>
            </li>
        <?php endif ?>

        <li>
            <a href="/user-menu/add-personal-data">
                <button class="button">Add personal data</button>
            </a>
        </li>

        <li>
            <a href="/user-menu/orders">
                <button class="button">Orders</button>
            </a>
        </li>


        <li>
            <form method="post" action="/app/actions/do_logout.php">
                <button class="button" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</div>