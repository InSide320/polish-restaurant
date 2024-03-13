<?php
function flash(?string $message = null): void
{
    if ($message) {
        $_SESSION['flash'] = $message;
    } else {
        if (!empty($_SESSION['flash'])) { ?>
            <div class="alert alert-danger mb-3">
                <?= $_SESSION['flash'] ?>
            </div>
        <?php }
        unset($_SESSION['flash']);
    }
}
