<?php

namespace Curingle\Transition;

class Transition
{
    private $params;

    public function __construct($params) {
        $this->params = $params;
    }

    public function getName() {
        return $this->params['name'];
    }

    public function withComment($comment) {
        $this->params['comment'] = $comment;

        return new Transition($this->params);
    }

    public function execute() {
        $defaults = array(
            'comment' => ''
        );

        $params = array_merge($defaults, $this->params);

        $body = array(
            'transition_execution' => array(
                'card' => $params['cardNumber'],
                'comment' => $params['comment']
            )
        );

        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );

        if( $params['requiresComment'] && empty($params['comment']) ) {
            throw new \Exception('This transition requires a comment.');
        }


        $client = $params['client'];
        $executionUrl = $params['executionUrl'];

        $request = $client->post($executionUrl, $headers, json_encode($body));
        $response = $request->send();

        return $response->isSuccessful();
    }
}
