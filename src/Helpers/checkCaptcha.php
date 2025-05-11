<?php
// captcha_helper.php

define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_aLnsFqR0IVvstUVt9tcaSI3ezQ2cbr8P4RquhJgU08171724');

/**
 * Проверяет токен SmartCaptcha
 *
 * @param string|null $token Токен капчи
 * @return bool Результат проверки
 */
function check_captcha($token) {
    // Если токен пустой, считаем проверку не пройденной
    if (empty($token)) {
        return false;
    }

    $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
    $args = [
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR']
    ];

    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Увеличиваем таймаут до 5 секунд
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Логируем результат для отладки
    error_log("SmartCaptcha response: code=$httpcode, output=$server_output");

    if ($httpcode !== 200) {
        // В случае ошибки сервера, можно решить, пропускать пользователя или нет
        // В продакшене лучше вернуть false и показать сообщение об ошибке
        return false;
    }

    $resp = json_decode($server_output);
    return isset($resp->status) && $resp->status === "ok";
}