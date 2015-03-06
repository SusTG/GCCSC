<?php

function esNoticia($item) {

    return substr($item->parent_route, 0, 8) == 'noticia/';
}
