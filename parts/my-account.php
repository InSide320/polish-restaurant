<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php $username = $_SESSION["username"]; ?>
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
                    <form method="post" action="/app/actions/do_logout.php">
                        <button class="button" type="submit">Logout</button>
                    </form>
                </li>
            </ul>

        </div>
        <div class="wrap-account-information">
            <div class="account-information">
                <p>
                    Witaj <b><?= $username ?></b> (nie jesteś <b><?= $username ?></b>? Wyloguj się)

                    W ustawieniach swojego konta możesz przejrzeć swoje ostatnie zamówienia,
                    zarządzać adresami płatności i dostawy oraz zmieniać hasło i szczegóły konta.
                </p>
            </div>
        </div>
    </div>
</section>
