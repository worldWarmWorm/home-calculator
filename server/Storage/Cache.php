<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

class Cache
{
    public function process(): string
    {

        $cache_dir = realpath(__DIR__) . '/cache/'; // Папка для кеша
        $cache_file = $cache_dir . 'page_cache.html'; // Имя файла кеша
        $cache_time = 3600; // Время жизни кеша в секундах (1 час)

        // Проверяем, существует ли файл кеша и не устарел ли он
        if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
            // Если кеш есть и актуален, выводим его
            return file_get_contents($cache_file);
        }

        // Кеша нет или он устарел, генерируем контент
        ob_start(); // Начинаем буферизацию вывода

        // --- Начинается ваш основной PHP-код и генерация HTML ---
        $html = "<html><body><h1>Динамически сгенерированная страница</h1>";
        // ... другой динамический контент ...
        $html .= "</body></html>";
        // --- Конец основного PHP-кода ---

        // Получаем содержимое буфера
        $page_content = ob_get_contents();
        ob_end_clean(); // Очищаем буфер

        // Записываем контент в кеш
        if (!is_dir($cache_dir)) { // Создаем директорию, если её нет
            mkdir($cache_dir, 0755, true);
        }
        file_put_contents($cache_file, $page_content);

        // Выводим сгенерированный контент
        return $page_content;
    }
}