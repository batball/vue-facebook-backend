<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Response;


class Response implements ResponseInterface
{
    /**
     * {@inheritDoc}
     */
    public static function json(array $data, int $statusCode = HttpStatus::OK, array $headers = []): void
    {
        $headers = array_merge(['Content-type' => 'application/json; charset=utf-8'], $headers);

        self::send(
            json_encode($data),
            $headers,
            $statusCode
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function send(string $data, array $headers, int $statusCode = 200): void
    {
        // this will clean up any previously added headers, to start clean
        header_remove();

        foreach ($headers as $header => $value){
            header($header.':'.$value);
        }

        http_response_code($statusCode);

        echo $data;

        exit();
    }
}