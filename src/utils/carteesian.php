<?php

namespace Phpai\utils;

function cartesian(array $set): array {

    if (!$set) {
        return array(array());
    }

    $subset = array_shift($set);
    $cartesianSubset = self::cartesian($set);

    $result = array();
    foreach ($subset as $value) {
        foreach ($cartesianSubset as $p) {
            array_unshift($p, $value);
            $result[] = $p;
        }
    }

    return $result;
}