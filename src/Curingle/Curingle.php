<?php

namespace Curingle;

use Curingle\Card;

class Curingle
{
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function card($cardNumber) {
        $request = $this->client->get("cards/{$cardNumber}.xml");
        $response = $request->send();

        $factory = new Card\Factory();

        return $factory->build($response->getBody(), $this->client); // returns a card
    }
}
