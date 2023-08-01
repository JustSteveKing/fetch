<?php

namespace Utopia\Fetch;

use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    /**
     * @dataProvider dataSet
     * @param string $body
     * @param array<string, string> $headers
     * @param int $statusCode
     * @param string $url
     * @param string $method
     * @return void
     */
    public function testClassConstructorAndGetters(
        $body,
        $headers,
        $statusCode,
        $url,
        $method,
    ): void {
        $resp = new Response(
            body: $body,
            headers: $headers,
            statusCode: $statusCode,
            url: $url,
            method: $method,
        );
        $this->assertEquals($body, $resp->getBody());
        $this->assertEquals($headers, $resp->getHeaders());
        $this->assertEquals($statusCode, $resp->getStatusCode());
        $this->assertEquals($url, $resp->getUrl());
        $this->assertEquals($method, $resp->getMethod());
    }

    /**
     * Data
     * @dataProvider dataSet
     * @param string $body
     * @param array<string, string> $headers
     * @param int $statusCode
     * @param string $url
     * @param string $method
     * @return void
     */
    public function testClassMethods(
        $body,
        $headers,
        $statusCode,
        $url,
        $method,
    ) {
        $resp = new Response(
            body: $body,
            headers: $headers,
            statusCode: $statusCode,
            url: $url,
            method: $method,
        );
        $this->assertEquals($body, $resp->getBody()); // Assert that the body is equal to the response's body
        $jsonBody = \json_decode($body, true); // Convert JSON string to object
        $this->assertEquals($jsonBody, $resp->json()); // Assert that the JSON body is equal to the response's JSON body
        $bin = ""; // Convert string to binary
        for($i = 0, $j = strlen($body); $i < $j; $i++) {
            $bin .= decbin(ord($body)) . " ";
        }
        $this->assertEquals($bin, $resp->blob()); // Assert that the blob body is equal to the response's blob body
    }
    /**
     * Data provider for testClassConstructorAndGetters and testClassMethods
     * @return array<string, array<mixed>>
     */
    public function dataSet()
    {
        return [
        'dummyResponse'=>[
            '{"name":"John Doe","age":30}',
            [
              'content-type' => 'application/json'
            ],
            200,
            'http://localhost:8001/post',
            'POST',
            'application/json'
          ],
        ];
    }
}
