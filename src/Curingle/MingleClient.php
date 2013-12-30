<?php

namespace Curingle;

use Guzzle\Service\Client;
use Guzzle\Common\Collection;

class MingleClient extends Client
{
    public static function factory($config = array()) {
        $default = array();

        // The following values are required when creating the client
        $required = array(
            'base_url',
            'project',
            'request.options'
        );

        $config = Collection::fromConfig($config, $default, $required);

        $base_url = $config->get('base_url') . "/api/v2/projects/{project}";
        return new self($base_url, $config);
    }
}
