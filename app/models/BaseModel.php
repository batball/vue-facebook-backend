<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Models;

use Webmozart\Assert\Assert;

class BaseModel
{
    private static ?\PDO $connection;
    private ?\PDO $pdo;


    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    private static function configuration(): array
    {
        return [
            'dsn'=> "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset=utf8;port=3306",
            'user_name'=> $_ENV['DB_USERNAME'],
            'password'=> $_ENV['DB_PASSWORD'],
            'options'=> [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ],
        ];
    }

    public function db(): \PDO
    {
        if (!isset(self::$connection)) {

            if (null !== $this->pdo){
                return $this->pdo;
            }

            $config = self::configuration();

            try {
                self::$connection =  new \PDO(
                    $config['dsn'],
                    $config['user_name'],
                    $config['password'],
                    $config['options'],
                );

                return self::$connection;

            } catch (\PDOException $exception) {
                throw new \Exception('Database connection failed.');
            }
        }

        return self::$connection;
    }

    private function validateConfiguration(array $config)
    {
        Assert::keyExists($config, 'dsn');
        Assert::keyExists($config, 'user_name');
        Assert::keyExists($config, 'password');
        Assert::keyExists($config, 'options');

        Assert::stringNotEmpty($config['dsn']);
        Assert::stringNotEmpty($config['user_name']);
        Assert::stringNotEmpty($config['password']);
        Assert::isArray($config['options']);
    }
}