<?php

namespace StringDecorator\Decorator;

use StringDecorator\Value\Decoration;

class LinkDecorator implements DecoratorInterface
{
    /**
     * @param string $subject
     * @return Decoration
     */
    public function decorate($subject)
    {
        return new Decoration('<a href="' . htmlspecialchars($subject, ENT_QUOTES) . '">', $subject, '</a>');
    }
}
