<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

function pr($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

require_once(dirname(__FILE__).'/src/Flare/Routing.php');

$routing = new Flare\Routing();
echo $routing->getRouteString();