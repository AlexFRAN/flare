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
    protected array $routes = [];    // The route-string, divided by slash


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
        $this->routes = explode('/', $routeString);

        return $routeString;
    }

    /**
     * Set a route-string manually
     * @param string $routeString
     */
    public function setRouteString($routeString)
    {
        $this->routeString = $routeString;
        $this->routes = explode('/', $routeString);
    }

    /**
     * Check all registered routers for a specific route
     * @param string $alias                 The current alias
     * @param int|bool $parentId            The parentId (router-internal key, every router can have their own key-management), if the item is root, this is false
     * @param string|bool $parentRouter     The key with which the parent Router has been added into the router-hive
     * @return object|bool                  If found, a route-object will be returned, otherwise false
     */
    public function matchRoute(string $alias, int|bool $parentId, string|bool $parentRouter): object|bool
    {
        foreach($this->routers as $router)
        {
            $route = $router->matchRoute($alias, $parentId, $parentRouter);

            if($route)
            {
                return $route;
            }
        }

        return false;
    }

    /**
     * Matches the current route-string
     * @TODO: Check what to do when user is on the homepage (route array will be empty)
     * @return object|bool
     * @throws Exception
     */
    public function matchRoutes()
    {
        $id = false;
        $parentId = false;
        $parentRouter = false;
        $route = false;

        foreach($this->routes as $alias)
        {
            try
            {
                $route = $this->matchRoute($alias, $parentId, $parentRouter);
            }
            catch(\Exception $e)
            {
                // TODO: This is only for testing purposes, remove this piece of junk and move 404 handling to a custom error handler
                echo "Error: ".$e->getMessage();

                return false;
            }

            if(!$route)
            {
                throw new \Exception("Route: ".$alias." not found", 404);
            }

            $parentId = $route->getId();
            $parentRouter = $route->getRouter();
        }

        return $route;
    }
}