<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Handlers;

use App\Models\Photo;
use App\Services\Facebook\FacebookService;

class GetUserPhotosHandler
{
    private FacebookService $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function __invoke(): array
    {
        try {
            $userId = $this->facebookService->user()['id'];
        }catch (\Exception $e){
            throw new \Exception('Failed to retrieve user.'. $e->getMessage());
        }

        $photoModel = new Photo();
        $count = $photoModel->userHasPhotos($userId);

        if (9 === $count) {
            return $photoModel->userPhotos($userId);
        }

        try {
            $photos = $this->facebookService->userPhotos( 9);
        }catch (\Exception $e){
            throw new \Exception('Failed to retrieve user photos.');
        }

        $photoModel->saveUserPhotos($userId, $photos['data']);

        return $photoModel->userPhotos($userId);
    }
}