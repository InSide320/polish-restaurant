<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <?php flash(); ?>
    <div class="wrap-authorization">
        <form class="login-form" method="post" action="/app/actions/do_login">
            <h3>LOGOWANIE</h3>
            <div>
                <label for="email">Adres e-mail<span style="color: #E01020;">*</span></label>
                <input type="email" name="email" id="email" required>
            </div>

            <div>
                <label for="password">Hasło<span style="color: #E01020;">*</span></label>
                <input type="password" name="password" id="password" required>
            </div>

            <button class="button" type="submit">Zalogować się</button>
            <a href="/forgot-password">Zapomniałeś hasła?</a>
        </form>
        <span></span>
        <div class="authorization-description">
            <h3>ZAREJESTRUJ SIĘ</h3>
            <p>
                Rejestracja na tej stronie umożliwia uzyskanie dostępu do statusu i historii zamówienia.
                Wypełnij poniższe pola, a my przygotujemy dla ciebie nowe konto w mgnieniu oka.
                Będziemy Cię prosić tylko o informacje niezbędne do przyspieszenia i ułatwienia procesu zakupu.
            </p>
            <a href="/registration">
                <button class="button">ZAREJESTRUJ SIĘ</button>
            </a>
        </div>
    </div>
</section>
