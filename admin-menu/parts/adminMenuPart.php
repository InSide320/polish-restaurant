<div class="account-menu">
    <ul>
        <li>
            <a href="/my-account">
                <button class="button">Back to User</button>
            </a>
        </li>
        <li>
            <a href="./admin-panel">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'admin-panel') ? 'active' : '' ?>">
                    Admin panel
                </button>
            </a>
        </li>
        <li>
            <a href="./add-new-product">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'add-new-product') ? 'active' : '' ?>">
                    Add new Product
                </button>
            </a>
        </li>
        <li>
            <a href="./manage-products">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'manage-products') ? 'active' : '' ?>">
                    Manage products
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
