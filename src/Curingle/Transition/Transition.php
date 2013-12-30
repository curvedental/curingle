<?php

namespace Curingle\Transition;

class Transition
{
    private $name;
    private $requires_comment;
    private $execution_url;

    private $client;
    private $card_number;

    public function __construct($params) {
        $this->name = $params['name'];
        $this->requires_comment = $params['requiresComment'];
        $this->execution_url = $params['executionUrl'];

        $this->client = $params['client'];
        $this->card_number = $params['cardNumber'];
    }

    public function getName() {
        return $this->name;
    }

    public function execute($comment="") {
        $body = array(
            'transition_execution' => array(
                'card' => $this->card_number,
                'comment' => $comment
            )
        );

        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );

        if( $this->requires_comment && empty($comment) ) {
            throw new \Exception('This transition requires a comment.');
        }


        $request = $this->client->post($this->execution_url, $headers, json_encode($body));
        $response = $request->send();

        return $response->isSuccessful();
    }
}
