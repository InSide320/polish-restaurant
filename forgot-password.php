<?php include 'header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-authorization">
        <form method="post" action="app/actions/send">
            <div>
                <p>Zapomniane hasło? Proszę wprowadzić nazwę użytkownika lub adres e-mail.
                    Wyślemy w wiadomości email, odnośnik potrzebny do utworzenia nowego hasła.
                </p>
                <label for="email">Nazwa użytkownika lub adres e-mail<span style="color: #E01020;">*</span></label>
                <input class="input" type="email" name="email" id="email">
                <button class="button" name="send" value="forgot-password" type="submit">ZRESETUJ HASŁO</button>
            </div>
        </form>
    </div>
</section>
<?php include 'footer.php'; ?>


