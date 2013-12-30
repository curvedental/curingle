<?php

namespace Curingle\Card;

use Curingle\Card\Card;

class Factory
{
    public function build($xml, $client) {
        $card_xml = simplexml_load_string($xml);

        $card = new Card(array(
            'number' => (string) $card_xml->number
        ), $client);


        return $card;
    }
}
