<?php
function url(): string
{
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']);
}

function getFullURL(): string
{
    return sprintf(
        "%s://%s/%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']);
}
