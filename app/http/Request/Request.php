<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Request;

class Request implements RequestInterface
{

    public static function queries(string $key= null, $default = null): mixed
    {
        if(null !== $key){
            return $_GET[$key] ?? $default;
        }

        return $_GET;
    }

    public static function jsonData(): array
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}