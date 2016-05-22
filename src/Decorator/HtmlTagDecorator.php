<?php

namespace StringDecorator\Decorator;

use StringDecorator\Value\Decoration;

class HtmlTagDecorator implements DecoratorInterface
{
    /** @var string */
    private $tag;

    private function __construct($tag)
    {
        $this->tag = $tag;
    }

    public static function create($tag)
    {
        return new static($tag);
    }
    
    public function decorate($subject)
    {
        return new Decoration(sprintf('<%s>', $this->tag), $subject, sprintf('</%s>', $this->tag));
    }
}
