<?php

use App\Services\Facebook\FacebookService;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook;
use Facebook\FacebookRequest;

/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */
class FacebookServiceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Facebook|\PHPUnit\Framework\MockObject\MockObject
     */
    private $mockFacebook;

    /**
     * @var FacebookService
     */
    private $faceBookService;

    private string $accessToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->accessToken = 'EAADZBw9neVLMBAIuyt3EwM79IXqLW7pbFp1NBnZBn68u0ZAr45xYWRDA3Y7S4UHnuvKyolm9beEtirWHIMFsEViCZBWGdtFOfOYUdPYdX1DX5tjukMvQxvJHk97XYA7yEVQ4EAvC0E8NCFm672aSinfwPb2QAhgeFjikE8BrjiEw2rG7HLwY46m3p1M42Sg5RmSUZBKwIsAZDZD';
        $this->mockFacebook = $this->createPartialMock(Facebook::class, ['get']);
        $this->faceBookService = new FacebookService($this->accessToken, $this->mockFacebook);
    }

    /**
     * @test
     */
    public function user_withNoParams_shouldReturnUserInformation()
    {
        $response = [
            'id' => '10225437529154183',
            'name' => 'Some user',
        ];
        $facebookResponse = new \Facebook\FacebookResponse(new \Facebook\FacebookRequest(), json_encode($response));
        $this->mockFacebook
            ->method('get')
            ->with('/me')
            ->willReturn($facebookResponse);


        $user = $this->faceBookService->user();

        $this->assertEquals($response, $user);
    }

    /**
     * @test
     */
    public function userPhotos_withLimit_shouldReturnPhotosArray()
    {
        $expectedPhotos = [
            'data' => [
                [
                    'id'=> '10220878646984978',
                    'source' => 'https://z-p3-scontent.fcmb8-1.fna.fbcdn.net/v/t1.6435-9/87753426_10220878647024979_669090462300110848_n.jpg',
                ],
                [
                    'id'=> '10156941610201376',
                    'source' => 'https://z-p3-scontent.fcmb8-1.fna.fbcdn.net/v/t1.6435-9/79545517_10156941610206376_6659903424504528896_n.jpg',
                ],
            ]
        ];

        $facebookResponse = new \Facebook\FacebookResponse(new \Facebook\FacebookRequest(), json_encode($expectedPhotos));

        $queries = [
            'fields' => 'id,source',
            'limit' => 2,
        ];

        $url = '/me/photos?'.http_build_query($queries);

        $this->mockFacebook
            ->method('get')
            ->with($url)
            ->willReturn($facebookResponse);

        $photos = $this->faceBookService->userPhotos(2);

        $this->assertEquals($expectedPhotos, $photos);
    }

    /**
     * @test
     */
    public function user_withNoParams_invalidAccessTokenShouldThrowFacebookResponseException()
    {
        $this->mockFacebook
            ->method('get')
            ->with('/me')
            ->willThrowException(
                new FacebookResponseException(
                new \Facebook\FacebookResponse(new FacebookRequest()
                )));

        $this->expectExceptionMessage('Graph returned an error Unknown error from Graph.');

        $this->faceBookService->user();
    }
}