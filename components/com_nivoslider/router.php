<?php

function nivosliderBuildRoute(&$opciones) {
    $segmentos = array();
    if (isset($opciones['view'])) {
        $segmentos[] = $opciones['view'];
        unset($opciones['view']);
    }
    return $segmentos;
}

function nivosliderParseRoute($segmentos) {
    return array(
        'view' => $segmentos[0]);
}
