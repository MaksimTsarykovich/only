<?php

declare(strict_types=1);

namespace Src\Authentication;

class YandexSmartCaptcha
{
    private string $serverKey;
    private ?string $lastError = null;

    public function __construct(string $serverKey)
    {
        $this->serverKey = $serverKey;
    }

    public function verify(?string $token): bool
    {

        $this->lastError = null;


        if (empty($token)) {
            $this->lastError = 'Токен капчи отсутствует';
            return false;
        }

        $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
        $args = [
            "secret" => $this->serverKey,
            "token" => $token,
            "ip" => $_SERVER['REMOTE_ADDR']
        ];

        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode !== 200) {
            $this->lastError = "Ошибка сервера капчи: code=$httpcode, output=$server_output";
            return false;
        }

        $resp = json_decode($server_output);
        if (!isset($resp->status) || $resp->status !== "ok") {
            $this->lastError = "Капча не пройдена: " . ($resp->message ?? 'неизвестная ошибка');
            return false;
        }

        return true;
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }
}