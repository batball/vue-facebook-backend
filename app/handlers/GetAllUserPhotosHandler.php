<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Handlers;

use App\Services\Facebook\FacebookService;

class GetAllUserPhotosHandler
{
    private FacebookService $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function __invoke(int $limit, array $page): array
    {
        try {
            return $this->facebookService->userPhotos($limit, $page);
        }catch (\Exception $e){
            throw new \Exception('Failed to retrieve user photos.');
        }
    }
}