<?php
namespace Flare\Router;


/**
 * Test router
 */
class PageRouter implements \Flare\RouterInterface
{
    private $routes = [];

    public function __construct()
    {
        $this->loadRoutes();
    }

    /**
     * Test method, remove this piece of shit when implementing real routing stuff
     */
    private function loadRoutes()
    {
        $this->routes = json_decode(file_get_contents(dirname(__DIR__, 3).'/pageRoutes.json'), true);
    }

    /**
     * Find a single route and return it as route-object
     * @TODO: Create route objects with a DI-Container / Library when project is expanded
     * @param string $alias
     * @param int|bool $parentId
     * @param string|bool $parentRouter
     * @return object|bool
     */
    public function matchRoute(string $alias, int|bool $parentId, string|bool $parentRouter): object|bool
    {
        // This is only temporary, otherwise it would be very, very inefficient in large projects
        foreach($this->routes as $route)
        {
            if($route['alias'] == $alias && $route['parentId'] == $parentId && $route['parentRouter'] == $parentRouter)
            {
                $content = new \Flare\PageTest($route['content']);

                return new \Flare\Route($route['id'], $alias, 'PageRouter', $content, $parentId, $parentRouter);
            }
        }

        return false;
    }

    /**
     * Method for testing purposes, returns the content of a single page
     * @TODO: Remove this piece of shit when testing is over
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function getPage(int $id): string
    {
        foreach($this->routes as $route)
        {
            if($route['id'] == $id)
            {
                return $route['content'];
            }
        }

        throw new \Exception("Page with the id: ".$id." not found.");
    }
}