<?php

namespace StringDecorator;

use StringDecorator\Decorator\DecoratorInterface;

class StringDecorator
{
    /**
     * A list of applicable decorators.
     * 
     * @var DecoratorIndex[]
     */
    private $indexes = [];

    /**
     * A text subject.
     *
     * @var string
     */
    private $text;

    private function __construct($text)
    {
        $this->text = $text;
    }

    public static function create($text)
    {
        return new static($text);
    }

    public function apply($start, $end, DecoratorInterface $decorator)
    {
        $this->indexes[] = new DecoratorIndex($start, $end, $decorator);
    }

    public function __toString()
    {
        /** @var DecoratorIndex $index */
        while ($index = array_shift($this->indexes)) {
            $subject = mb_substr($this->text, $index->getStart(), $index->getLength());
            $decoration = $index->decorate($subject);
            $replacement = (string) $decoration;

            $this->text = mb_substr($this->text, 0, $index->getStart())
                . $replacement
                . mb_substr($this->text, $index->getEnd());

            array_walk($this->indexes, function (DecoratorIndex &$unused) use (
                $index, $decoration, $replacement, $subject
            ) {
                if ($unused->getStart() >= $index->getStart() && $unused->getEnd() <= $index->getEnd()) {
                    // index is inside of current index so only shift by decoration prefix length
                    $unused->shift(mb_strlen($decoration->getPrefix()));
                } elseif ($unused->getStart() >= $index->getEnd()) {
                    // decorator is far to the right so shift by full length of replacement string
                    $unused->shift(mb_strlen($replacement) - mb_strlen($subject));
                } elseif ($newIndexes = DecoratorIndexSplitter::split($index, $unused)) {
                    $unused = null;
                    array_push($this->indexes, ...$newIndexes);
                }
            });

            $this->indexes = array_filter($this->indexes);
        }

        return $this->text;
    }

    public function render()
    {
        return (string) $this;
    }
}
