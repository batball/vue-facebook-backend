<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */
class Photo extends BaseModel
{
    public function userPhotos(int $userId): array
    {
        $sql = 'select `id`, `url` from photos where `user_id` = :userId';

        try {
            $query = $this->db()->prepare($sql);
            $query->execute([
                ':userId' => $userId,
            ]);

            return $query->fetchAll();

        }catch (\Exception $exception){
            throw new \Exception('Unable to get the user photos.');
        }
    }

    public function saveUserPhotos(int $userId, array $photos): bool
    {
        Assert::count($photos, 9);
        $data = [];

        foreach ($photos as $photo){
            $data[] = "({$userId}, {$photo['id']}, '{$photo['source']}')";
        }


        try {
            $this->deleteUserPhotos($userId);

            $sql = "INSERT INTO `photos` (`user_id`, `reference_id`, `url`) 
                    VALUES " .implode(',', $data)." ";


            $this->db()->beginTransaction();
            $stmt = $this->db()->prepare($sql);
            $stmt->execute();
            return $this->db()->commit();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }

    public function userHasPhotos(int $userId): int
    {
        $sql = 'select count(`id`) as count from `photos` where `user_id` = :userId';

        try {
            $query = $this->db()->prepare($sql);
            $query->execute([
                ':userId' => $userId,
            ]);

            return current($query->fetch());
        }catch (\Exception $exception){
            throw new \Exception('Unable to get the user photo count.');
        }

    }

    public function deleteUserPhotos(int $userId): bool
    {
        try {
            $sql = 'DELETE from `photos` WHERE `user_id` = :userId';
            $this->db()->beginTransaction();
            $stmt = $this->db()->prepare($sql);
            $stmt->execute([
                ':userId' => $userId,
            ]);
            return $this->db()->commit();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}