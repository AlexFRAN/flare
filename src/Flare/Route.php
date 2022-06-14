<?php
namespace Flare;

/**
 * The main route-class, every route in Flare is an instance of this object
 */
class Route
{
    protected int $id;
    protected string $alias;
    protected string $router;
    protected int|bool $parentId;
    protected string|bool $parentRouter;
    protected object|bool $content;

    /**
     * Use constructor for intializing values
     * TODO: Are there initializer-lists in php that work? If yes, refactor!
     * @param int $id
     * @param string $alias
     * @param string $router
     * @param object $content           An instance of the class that handles the content for this route, can be anything you like, create a pageclass, productclass, blogclass...
     * @param int|bool $parentId
     * @param string|bool $parentRouter
     */
    public function __construct(int $id, string $alias, string $router, object $content, int|bool $parentId = false, string|bool $parentRouter = false)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->router = $router;
        $this->content = $content;
        $this->parentId = $parentId;
        $this->parentRouter = $parentRouter;
    }

    /**
     * Get the own id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return the current alias, note that this will return only the current piece, not the entire route, for instance:
     * The complete route is: /products/category1/product2 and the current route-piece is category1, then only the string "category1" will be returned
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Get the router for this route
     * @return string
     */
    public function getRouter(): string
    {
        return $this->router;
    }

    /**
     * Get the custom content-class instance
     * @return object
     */
    public function getContent(): object
    {
        return $this->content;
    }

    /**
     * Get the parent-id if it is not a root-item
     * @return int|bool
     */
    public function getParentId(): int|bool
    {
        return $this->parentId;
    }

    /**
     * Get the name of the parent-router if its not a root item
     * @return string|bool
     */
    public function getParentRouter(): string|bool
    {
        return $this->parentRouter;
    }
}