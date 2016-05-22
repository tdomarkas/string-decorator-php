<?php

namespace StringDecorator;

/**
 * Splits decorator indexes if they collide.
 */
final class DecoratorIndexSplitter
{
    /**
     * @param DecoratorIndex $subject
     * @param DecoratorIndex $splitter
     * @return DecoratorIndex[]
     */
    public static function split(DecoratorIndex $subject, DecoratorIndex $splitter)
    {
        $newDecorators = [];

        if ($splitter->getStart() < $subject->getStart()) {
            if ($splitter->getEnd() > $subject->getStart() && $splitter->getEnd() <= $subject->getEnd()) {
                $newDecorators[] = $splitter->duplicate($splitter->getStart(), $subject->getStart());
                $newDecorators[] = $splitter->duplicate($subject->getStart(), $splitter->getEnd());
            } elseif ($splitter->getEnd() > $subject->getStart() && $splitter->getEnd() > $subject->getEnd()) {
                $newDecorators[] = $splitter->duplicate($splitter->getStart(), $subject->getStart());
                $newDecorators[] = $splitter->duplicate($subject->getStart(), $subject->getEnd());
                $newDecorators[] = $splitter->duplicate($subject->getEnd(), $splitter->getEnd());
            }
        } elseif (
            $splitter->getStart() >= $subject->getStart()
            && $splitter->getStart() < $subject->getEnd()
            && $splitter->getEnd() > $subject->getEnd()
        ) {
            $newDecorators[] = $splitter->duplicate($splitter->getStart(), $subject->getEnd());
            $newDecorators[] = $splitter->duplicate($subject->getEnd(), $splitter->getEnd());
        }

        return $newDecorators;
    }
}
