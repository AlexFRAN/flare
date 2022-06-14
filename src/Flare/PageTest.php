<?php
namespace Flare;

/**
 * Test content class for static pages
 * This is only for testing purposes, as soon as other means are available, replace this junk with real content management classes
 */
class PageTest
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}