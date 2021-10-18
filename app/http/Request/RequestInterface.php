<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Request;

interface RequestInterface
{
    public static function jsonData(): array;
}