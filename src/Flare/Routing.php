<?php
namespace Flare;


/**
 * Routing management class
 * Manages different routers, loaded into the system and tries to match the routes / path in a hierarchical way
 */
class Routing
{
    protected $routers = [];    // In here we store all the different router instances
    protected string $routeString = '';     // The current, cleaned route-string
    protected array $route = [];    // The route-string, divided by slash


    /**
     * Add a new router to the router-hive
     * @param string $key       // The key, with which you want to label & find the router
     * @param object $router    // The instance of 
     */
    public function addRouter(string $key, object $router)
    {
        if(isset($this->routers[$key]))
        {
            throw new \Exception('Router: '.$key.' already exists.');
        }

        $this->routers[$key] = $router;
    }

    /**
     * Get a specific router
     * @param string $key
     * @return object|bool
     */
    public function getRouter(string $key)
    {
        return isset($this->routers[$key]) ? $this->routers[$key] : false;
    }

    /**
     * Cut the get-parameters from a url
     * @param string $url
     * @return string
     */
    public function removeQuery($url)
    {
        $url = explode('?', $url);
        
        return $url[0];
    }

    /**
     * Get and clean the current route-string
     * @TODO: Refactor this piece of junk, implementation only temporarily
     * @return string
     */
    public function getRouteString()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        $routeString = str_replace($baseUrl, '', $url['path']);
        $routeString = trim($routeString, '/');
        $this->routeString = $routeString;
        $this->route = explode('/', $routeString);

        return $routeString;
    }

    /**
     * Set a route-string manually
     * @param string $routeString
     */
    public function setRouteString($routeString)
    {
        $this->routeString = $routeString;
        $this->route = explode('/', $routeString);
    }
}