<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Controllers;

use App\Request\Request;
use App\Handlers\GetAllUserPhotosHandler;
use App\Response\HttpStatus;
use App\Services\Facebook\FacebookService;


class GetAllUserPhotosController extends BaseController
{
    public function __invoke(): void
    {
        $accessToken = Request::queries('access_token');
        $limit = Request::queries('limit', 100);

        $page = [];
        $after = Request::queries('after');
        $before = Request::queries('before');

        if (null !== $after) {
            $page['after'] = $after;
        }

        if (null !== $before) {
            $page['before'] = $before;
        }

        try {
            $photos = (new GetAllUserPhotosHandler(new FacebookService($accessToken)))
                ->__invoke(
                    $limit,
                    $page
                );

            if (isset($photos['paging']['next'])) {
                unset($photos['paging']['next']);
            }

            if (isset($photos['paging']['previous'])) {
                unset($photos['paging']['previous']);
            }

            $this->response($photos);
        } catch (\Exception $exception) {
            $this->response([
                'error' => 'Server error',
                'message' => $exception->getMessage()
            ],
                HttpStatus::INTERNAL_SERVER_ERROR);
        }
    }
}