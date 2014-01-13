<?php

namespace Curingle\Tests\Transition;

use Curingle\Transition\Transition;
use Curingle\MingleClient;

class TransitionTestCase extends \Guzzle\Tests\GuzzleTestCase
{
    public function setUp() {
        $this->mockClient = $this->getMock('MingleClient', array('post'));

        $this->expectedUrl = "https://some.execution-url.com";
        $this->expecetedCardNumber = 12345;

        $params = array(
            'name' => "My Transition",
            'requiresComment' => true,
            'executionUrl' => $this->expectedUrl,
            'client' => $this->mockClient,
            'cardNumber' => $this->expecetedCardNumber
        );
        $this->transition = new Transition($params);
    }

    /**
     * @expectedException         Exception
     * @expectedExceptionMessage  This transition requires a comment.
     */
    public function testThrowsExceptionWhenTransitionRequiresCommentAndNoneProvided() {
        $this->transition->execute();
    }

    public function testPostsExpctedValues() {
        $stubResponse = $this->getMock('stdClass', array('isSuccessful'));
        $stubResponse->expects($this->once())
                     ->method('isSuccessful')
                     ->will($this->returnValue(true));

        $stubRequest = $this->getMock('stdClass', array('send'));
        $stubRequest->expects($this->once())
                    ->method('send')
                    ->will($this->returnValue($stubResponse));


        $expectedComment = "A Comment";

        $expectedHeaders = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );
        $expectedJson = json_encode(array(
            'transition_execution' => array(
                'card' => $this->expecetedCardNumber,
                'comment' => $expectedComment
            )
        ));
        $this->mockClient->expects($this->once())
                         ->method('post')
                         ->with($this->equalTo($this->expectedUrl),
                                $this->equalTo($expectedHeaders),
                                $this->equalTo($expectedJson))
                         ->will($this->returnValue($stubRequest));

        $result = $this->transition->withComment($expectedComment)->execute();

        $this->assertTrue($result);
    }
}
