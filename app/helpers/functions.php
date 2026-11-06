<?php

function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
function money(int|float $n): string
{
    return number_format($n, 0, ',', '.') . 'đ';
}