<?php

namespace Curingle\Transition;

use Curingle\Transition\Transition;

class Factory
{
    public function build($xml, $client, $cardNumber) {
        $transitions_xml = simplexml_load_string($xml);

        $transitions = array();
        foreach($transitions_xml->transition as $transition_xml) {
            $transition = new Transition(array(
                'name' => (string) $transition_xml->name,
                'requiresComment' => (string) $transition_xml->require_comment === "true",
                'executionUrl' => (string) $transition_xml->transition_execution_url,
                'client' => $client,
                'cardNumber' => $cardNumber
            ));


            array_push($transitions, $transition);
        }

        return $transitions;
    }
}
