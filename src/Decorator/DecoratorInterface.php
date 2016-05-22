<?php

namespace StringDecorator\Decorator;

use StringDecorator\Value\Decoration;

interface DecoratorInterface
{
    /**
     * @param string $subject
     * @return Decoration
     */
    public function decorate($subject);
}
