<?php
namespace Flare;

/**
 * Every router has to implement this interface to ensure compatibility
 */
interface RouterInterface
{
    /**
     * Find a route by its alias and parent
     * @param string $alias             The current url-piece, for instance if the url is /products/category1/product1, it may be one of those pieces
     * @param int|bool $parent_id       If it is not the root item, this will be the id in the specific router, every router can have their own key management, if its root, this will be false
     * @param string|bool $parentRouter The key with which the router-class of the parent route was added to the list of routers in the routing class, if its root, this is false
     * @return object|bool              If the route is found, a route-object is returned, otherwise false
     */
    public function matchRoute(string $alias, int|bool $parentId, string|bool $parentRouter): object|bool;
}