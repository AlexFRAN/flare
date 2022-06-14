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
require_once(dirname(__FILE__).'/src/Flare/RouterInterface.php');
require_once(dirname(__FILE__).'/src/Flare/Router/PageRouter.php');
require_once(dirname(__FILE__).'/src/Flare/Route.php');
require_once(dirname(__FILE__).'/src/Flare/PageTest.php');

$routing = new Flare\Routing();
$pageRouter = new Flare\Router\PageRouter();
$routing->addRouter('PageRouter', $pageRouter);
echo $routing->getRouteString();
echo '<br/>';

try
{
    $route = $routing->matchRoutes();
}
catch(Exception $e)
{
    echo "Error: ".$e->getCode().": ".$e->getMessage();
    exit;
}

echo $route->getContent()->getContent();