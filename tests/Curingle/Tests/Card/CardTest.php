<?php

namespace Curingle\Tests\Card;

use Curingle\Card\Card;

class CardTestCase extends \Guzzle\Tests\GuzzleTestCase
{
    public function setUp() {
        $this->setMockBasePath("tests/mock");

        $this->testClient = $this->getServiceBuilder()->get('test.mingle');
        $this->setMockResponse($this->testClient, "transitions.xml");

        $this->card = new Card(array('number' => 12345), $this->testClient);
    }

    /**
     * @expectedException         Exception
     * @expectedExceptionMessage  No transition matching that name.
     */
    public function testThrowsExceptionWhenNoMatchingTransition() {
        $this->card->transition("Start Transition");
    }

    public function testReturnsTransitionWhenMatchingOneFound() {
        $expectedName = "Start development";
        $transition = $this->card->transition($expectedName);

        $this->assertEquals($expectedName, $transition->getName());
    }
}
