<?php

namespace StringDecorator;

use StringDecorator\Decorator\DecoratorInterface;
use StringDecorator\Value\Decoration;

class DecoratorIndex implements DecoratorInterface
{
    /** @var integer */
    private $start;

    /** @var integer */
    private $end;

    /** @var DecoratorInterface */
    private $decorator;

    /**
     * Creates a decorator index.
     *
     * @param integer $start
     * @param integer $end
     * @param DecoratorInterface $decorator
     */
    public function __construct($start, $end, DecoratorInterface $decorator)
    {
        $this->start = $start;
        $this->end = $end;
        $this->decorator = $decorator;
    }

    /** @return integer */
    public function getStart()
    {
        return $this->start;
    }

    /** @param integer $start */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /** @return integer */
    public function getEnd()
    {
        return $this->end;
    }

    /** @param integer $end */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /** @return integer */
    public function getLength()
    {
        return $this->end - $this->start;
    }

    /**
     * Forward text subject to an actual decorator.
     *
     * @param string $subject
     * @return Decoration
     */
    public function decorate($subject)
    {
        return $this->decorator->decorate($subject);
    }

    /**
     * Clone an object with new indexes.
     *
     * @param integer $start
     * @param integer $end
     * @return DecoratorIndex
     */
    public function duplicate($start, $end)
    {
        return new static($start, $end, $this->decorator);
    }

    /**
     * Shift start and end indexes by a certain number.
     *
     * @param integer $increment
     */
    public function shift($increment)
    {
        $this->start += $increment;
        $this->end += $increment;
    }
}
