<div class="wrap-my-account">
    <?php $username = $_SESSION["username"]; ?>
    <?php include_once 'parts/userMenuPart.php'?>
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
