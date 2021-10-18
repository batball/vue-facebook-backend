<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Services\FaceBook;

interface FacebookServiceInterface
{
    public function user(): array;

    public function userPhotos(int $limit = 100, array $page = null): array;
}