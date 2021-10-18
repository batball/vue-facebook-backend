<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Response;

interface ResponseInterface
{
    /**
     * This function will generate a json response
     *
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     */
    public static function json(array $data, int $statusCode = 200, array $headers = []);

    /**
     * @param string $data
     * @param array $headers
     * @param int $statusCode
     */
    public static function send(string $data, array $headers, int $statusCode = 200);
}