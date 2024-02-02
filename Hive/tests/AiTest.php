<?php


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryTestCase;


class AiTest extends MockeryTestCase
{
    public function testApi(): void
    {
        $httpClientMock = Mockery::mock(\GuzzleHttp\Client::class);
        $expectedRequestBody = [
            'move_number' => '1',
            'hand' => [
                ['Q' => 1, 'B' => 1, 'A' => 1, 'S' => 1, "G" => 1],
                ['Q' => 1, 'B' => 1, 'A' => 1, 'S' => 1, "G" => 1],
            ]
        ];

        $httpClientMock->shouldReceive('post')
            ->once()
            ->with(
                'http://ai:6000/',
                [
                    'json' => $expectedRequestBody, // Assuming you are sending JSON in the request body
                    'headers' => ['Content-Type' => 'application/json'],
                ]
            )
            ->andReturn(
                Mockery::mock('Psr\Http\Message\ResponseInterface', [
                    'getBody' => Mockery::mock('Psr\Http\Message\StreamInterface', [
                        'getContents' => '["play", "B", "0,0"]',
                    ]),
                ])
            );

        $ai = new AI($httpClientMock);
        $response = $ai->getMove();
    }

    protected function tearDown(): void {
        Mockery::close();
    }

}
