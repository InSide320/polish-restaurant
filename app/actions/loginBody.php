<?php

$loginbody = "
                <div class='mail-message'>
    <div class='wrap-mail-message'>
        <a href=$sendUrl><img src=cid:logo width='200px'
                                       height='100px' alt='logo'></a>
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
</div>";

//<style>
//    .mail-message {
//        background-color: rgb(189, 163, 134);
//        border-radius: 10px;
//
//        & a {
//            &:link,
//            &:visited {
//                color: #333;
//            }
//
//            &:hover {
//                color: rgb(204, 0, 98);
//            }
//        }
//
//        & .wrap-mail-message {
//            display: flex;
//            flex-direction: column;
//            gap: 25px;
//
//            color: #333;
//            width: auto;
//            height: auto;
//            padding: 30px;
//            font-size: 24px;
//
//            .mail-body {
//                display: flex;
//                flex-direction: column;
//                gap: 10px;
//            }
//
//            & p {
//                display: flex;
//                gap: 10px;
//                margin: 0;
//            }
//        }
//    }
//</style>
