<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Controllers;

use App\Response\HttpStatus;
use App\Response\Response;

class BaseController
{
    public function response(array $data, int $status = HttpStatus::OK): void
    {
        Response::json($data, $status);
    }
}
