<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Controllers;

use App\Handlers\GetUserPhotosHandler;
use App\Request\Request;
use App\Response\HttpStatus;
use App\Services\Facebook\FacebookService;

final class GetUserPhotoController extends BaseController
{
    public function __invoke(): void
    {
        $accessToken = Request::queries('access_token');

        try {
            $photos = (new GetUserPhotosHandler(new FacebookService($accessToken)))->__invoke();
            $this->response(['data' => $photos]);
        } catch (\Exception $exception) {
            $this->response([
                'error' => 'Server error',
                'message' => $exception->getMessage()
            ],
            HttpStatus::INTERNAL_SERVER_ERROR
            );
        }
    }
}