<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <?php $username = $_SESSION["username"]; ?>

    <div class="wrap-my-account">
        <?php include './parts/adminMenuPart.php' ?>
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
<?php include_once './../footer.php'; ?>
