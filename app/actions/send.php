<?php

require_once './../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once './../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './../../vendor/phpmailer/phpmailer/src/SMTP.php';

require_once 'userActions.php';
require_once 'getUrl.php';
require_once './../../config/DBHelper.php';
include_once 'handleErrorMessage.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Random\RandomException;

function configureMailer($subject, $body): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    /**
     * SSL certificate will needed change
     * The correct fix for this is to replace the invalid,
     * misconfigured or self-signed certificate with a good one.
     */
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dekud2109@gmail.com'; // your gmail
    $mail->Password = 'xwbj jbnz poho gwng'; // your gmail pass
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->CharSet = 'utf8mb4';

    try {
        $mail->setFrom('dekud2109@gmail.com'); // your gmail
    } catch (Exception $e) {
        flash("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

    return $mail;
}

if (isset($_POST["send"])) {

    $sendUrl = url();
    $userExists = DBHelper::userExistsWithEmail($_POST['email']);

    if ($_POST['send'] === 'registration') {
        if (!$userExists) {
            $pass_generated = '';
            $username = generateUsernameFromEmail($_POST["email"]);
            try {
                try {
                    $pass_generated = generatePassword();
                } catch (RandomException $e) {
                    echo $e->getMessage();
                }

                $mail = configureMailer("Registration was successful", "
                    <div class='mail-message'>
                        <div class='wrap-mail-message'>
                            <a href=$sendUrl><img src=cid:logo width='200px' height='100px' alt='logo'></a>
                            <div class='mail-body'>
                                <p>Oto Twoje dane, zapisz je:</p>
                                <p>Nazwa użytkownika:
                                    <b>$username</b>
                                </p>
                                <p>
                                    hasło:<b>$pass_generated</b>
                                </p>
                                <p>aby wejść na stronę: <a href=$sendUrl>Link</a></p>
                            </div>
                        </div>
                    </div>
                ");

                $mail->addAddress($_POST["email"]);
                $mail->addEmbeddedImage('./../../assets/img/logo.png', 'logo', 'logo.png');

                saveUserToDB($username, $_POST["email"], $pass_generated);
                $mail->send();
            } catch (Exception $e) {
                flash("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
            flash('Sent Successful');
        } else {
            flash('This email already used');
        }
    } elseif ($_POST['send'] === 'forgot-password') {
        if ($userExists) {
            $key = '';
            try {
                $key = md5($userExists['email'] . random_int(1000, 9999));
            } catch (RandomException $e) {
                echo $e->getMessage();
            }
            $changePasswordUrl = $sendUrl . '/password-recovery?key=' . $key;

            $mail = configureMailer("Odzyskaj hasło", "
                <div class='mail-message'>
                    <div class='wrap-mail-message'>
                        <a href=$sendUrl>
                            <img src=cid:logo width='200px' height='100px' alt='logo'>
                        </a>
                        <div class='mail-body'>
                            <p>Witaj <b>$userExists[email]</b>, tutaj jest link do zmiany hasła: 
                                <b><a href=$changePasswordUrl>$changePasswordUrl</a></b>
                            </p>
                        </div>
                    </div>
                </div>
            ");

            try {
                $mail->addAddress($userExists['email']);
                $mail->addEmbeddedImage('./../../assets/img/logo.png', 'logo', 'logo.png');
                $mail->send();
                DBHelper::updateUserChangeKey($userExists['email'], $key);
            } catch (Exception $e) {
                flash("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
            flash('Sent Successful');
        } else {
            flash('This user not created');
        }
    } elseif ($_POST['send'] === 'order') {
        header("Location: /");
    }
    include './../../my-account.php';
}
