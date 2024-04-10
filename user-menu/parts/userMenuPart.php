<div class="account-menu">
    <ul>
        <?php if ((int)$_SESSION['role'] === 1): ?>
            <li>
                <a href="/admin-menu/admin-panel">
                    <button class="button">Admin panel</button>
                </a>
            </li>
        <?php endif ?>
        <?php if ((int)$_SESSION['role'] === 1 || (int)$_SESSION['role'] === 2): ?>
            <li>
                <a href="/manager-menu/manager-panel">
                    <button class="button">Manager panel</button>
                </a>
            </li>
        <?php endif ?>
        <li>
            <a href="/user-menu/add-personal-data">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'add-personal-data') ? 'active' : '' ?>">
                    Add personal data
                </button>
            </a>
        </li>

        <li>
            <a href="/user-menu/orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'orders') ? 'active' : '' ?>">Orders
                </button>
            </a>
        </li>


        <li>
            <form method="post" action="/app/actions/do_logout.php">
                <button class="button" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</div>