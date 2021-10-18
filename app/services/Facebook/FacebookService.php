<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

namespace App\Services\Facebook;

use Facebook\Facebook;

class FacebookService implements FacebookServiceInterface
{
    private Facebook $api;
    private string $accessToken;

    public function __construct(string $accessToken, ?Facebook $facebook = null)
    {
        $this->api = $facebook ?? new Facebook([
            'app_id' => $_ENV['FACEBOOK_APP_ID'],
            'app_secret' => $_ENV['FACEBOOK_APP_SECRET'],
            'default_graph_version' => 'v12.0',
            'default_access_token' => $accessToken
        ]);
    }

    public function user(): array
    {
        try {
            return $this->api->get('/me')->getDecodedBody();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception('Graph returned an error '. $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception('Facebook SDK returned an error: ');
        }
    }

    public function userPhotos(int $limit = 100, array $page = null): array
    {
        $queries = [
            'fields' => 'id,source',
            'limit' => $limit,
        ];

        if(isset($page['after'])){
            $queries['after'] = $page['after'];
        }

        if(isset($page['before'])){
            $queries['before'] = $page['before'];
        }

        try {

            $url = '/me/photos?'.http_build_query($queries);

            return $this
                ->api
                ->get($url)
                ->getDecodedBody();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception('Graph returned an error');
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception('Facebook SDK returned an error: ');
        }
    }
}