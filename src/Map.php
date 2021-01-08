<?php

namespace Startcode\Router;

use Aura\Router\Exception;

class Map extends \Aura\Router\Map
{

    protected function getNextAttach() : array
    {
        $key = key($this->attach_routes);
        $val = array_shift($this->attach_routes);

        if (is_string($key) && is_string($val)) {
            $spec = [
                'name' => $key,
                'path' => $val,
                'values' => [],
            ];
        } elseif (is_int($key) && is_string($val)) {
            $spec = [
                'path' => $val,
            ];
        } elseif (is_string($key) && is_array($val)) {
            $spec = $val;
            $spec['name'] = $key;
        } elseif (is_int($key) && is_array($val)) {
            $spec = $val;
        } else {
            throw new Exception\UnexpectedType("Route spec for '$key' should be a string or array.");
        }

        unset($spec['name_prefix']);
        unset($spec['path_prefix']);

        $spec = array_merge_recursive($this->attach_common, $spec);

        return $spec;
    }
}
