<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Controllers;

use App\Handlers\SaveUserPhotoHandler;
use App\Request\Request;
use App\Response\HttpStatus;
use App\Services\Facebook\FacebookService;

class SaveUserSelectedPhotosController extends BaseController
{
    public function __invoke(): void
    {
        $accessToken = Request::queries('access_token');
        $data = Request::jsonData();

        try {
            $this->response(['data' => (new SaveUserPhotoHandler(new FacebookService($accessToken)))
                ->__invoke($data)]);
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