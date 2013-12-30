<?php

namespace Curingle\Card;

class Card
{
    private $number;
    private $client;

    public function __construct($params, $client) {
        $this->number = $params['number'];
        $this->client = $client;
    }

    public function getNumber() {
        return $this->number;
    }

    public function transition($name) {
        $transition = $this->getTransition($name);

        if(empty($transition)) {
            throw new \Exception('No transition matching that name.');
        }

        return $transition;
    }

    private function getTransition($name) {
        $transitions = $this->loadTransitions();

        foreach($transitions as $transition) {
            if( $transition->getName() === $name ) {
                return $transition;
            }
        }

        return null;
    }

    // Returns an array of possible transitions for this card.
    private function loadTransitions() {
        $request = $this->client->get("cards/{$this->number}/transitions.xml");
        $response = $request->send();

        $factory = new \Curingle\Transition\Factory();

        return $factory->build($response->getBody(), $this->client, $this->number);
    }

}
