<?php

namespace Curingle\Tests;

use Curingle\Curingle;

class CuringleTestCase extends \Guzzle\Tests\GuzzleTestCase
{
    public function setUp() {
        $this->setMockBasePath("tests/mock");

        $this->testClient = $this->getServiceBuilder()->get('test.mingle');
        $this->setMockResponse($this->testClient, "card.xml");

        $this->curingle = new Curingle($this->testClient);
    }

    public function testGetsCard() {
        // Arrange
        $number = 21594;
        $expecedUrl = $this->testClient->getBaseUrl() . "/cards/{$number}.xml";

        // Act
        $this->curingle->card($number);

        $requests = $this->getMockedRequests();
        $request = $requests[0];

        // Assert
        $this->assertCount(1, $this->getMockedRequests());
        $this->assertEquals($expecedUrl, $request->getUrl());
    }

    public function testBuildsCard() {
        // Arrange
        $number = 21;
        $expecedUrl = $this->testClient->getBaseUrl() . "/cards/{$number}.xml";

        // Act
        $card = $this->curingle->card($number);

        // Assert
        $this->assertEquals($number, $card->getNumber());
    }
}
