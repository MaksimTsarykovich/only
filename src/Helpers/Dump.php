<?php

namespace Src\Helpers;

class Dump
{
    public static function dd(...$vars){
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=utf-8');
        }

        // Стили для красивого отображения
        echo '<style>
        pre.dd {
            background-color: #1e1e1e;
            color: #f8f8f2;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
            overflow: auto;
            max-width: 100%;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        pre.dd .type {
            color: #ff79c6;
            font-weight: bold;
        }
        pre.dd .key {
            color: #8be9fd;
        }
        pre.dd .value {
            color: #f1fa8c;
        }
        pre.dd .null {
            color: #bd93f9;
        }
        pre.dd .bool {
            color: #bd93f9;
        }
        pre.dd .number {
            color: #bd93f9;
        }
        pre.dd .string {
            color: #50fa7b;
        }
        pre.dd .resource {
            color: #f1fa8c;
        }
        pre.dd .backtrace {
            color: #8be9fd;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #444;
        }
    </style>';

        // Получаем информацию о вызове функции
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $file = $backtrace['file'] ?? 'unknown';
        $line = $backtrace['line'] ?? 'unknown';

        // Выводим каждую переменную
        foreach ($vars as $var) {
            echo '<pre class="dd">';
            echo '<div class="backtrace">Called from: ' . $file . ' (line ' . $line . ')</div>';
            echo formatVar($var);
            echo '</pre>';
        }

        // Завершаем выполнение скрипта
        die(1);
    }

}