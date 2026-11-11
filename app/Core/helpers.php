<?php

if (!function_exists('getSettingValue')) {
    function getSettingValue(array $settings, string $key): string
    {
        return (string) ($settings[$key] ?? '');
    }
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}