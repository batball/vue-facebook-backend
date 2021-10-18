<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Handlers;

use App\Models\Photo;
use App\Services\Facebook\FacebookService;

class SaveUserPhotoHandler
{
    private FacebookService $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function __invoke(array $data): array
    {
        try {
            $userId = $this->facebookService->user()['id'];
        }catch (\Exception $e){
            throw new \Exception('Failed to retrieve user.');
        }

        $photoModel = new Photo();
        $photoModel->saveUserPhotos($userId, $data);

        return $photoModel->userPhotos($userId);
    }
}