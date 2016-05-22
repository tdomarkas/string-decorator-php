<?php

namespace StringDecorator;

use StringDecorator\Decorator\DecoratorInterface;

class DecoratorIndexSplitterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideSplittingScenarios
     * @param array[] $expectedIndexes
     * @param integer[] $subject
     * @param integer[] $splitter
     * @param string $comment
     */
    public function testSplit($expectedIndexes, $subject, $splitter, $comment)
    {
        $subject = new DecoratorIndex($subject[0], $subject[1], $this->getSimpleMock(DecoratorInterface::class));
        $splitter = new DecoratorIndex($splitter[0], $splitter[1], $this->getSimpleMock(DecoratorInterface::class));

        $newIndexes = array_map(
            static function (DecoratorIndex $index) {
                return [$index->getStart(), $index->getEnd()];
            },
            DecoratorIndexSplitter::split($subject, $splitter)
        );

        $this->assertArrayEquals($newIndexes, $expectedIndexes, $comment);
    }
    
    public static function provideSplittingScenarios()
    {
        return [
            // " aa"
            // "   b"
            [
                [],
                [1, 3],
                [3, 4],
                'No collision (1)'
            ],

            // " aa"
            // "b"
            [
                [],
                [1, 3],
                [0, 1],
                'No collision (2)'
            ],

            // " aa"
            // "bb"
            [
                [[0, 1], [1, 2]],
                [1, 3],
                [0, 2],
                'Left side collision'
            ],

            // " aa "
            // "bbbb"
            [
                [[0, 1], [1, 3], [3, 4]],
                [1, 3],
                [0, 4],
                'Overlapping collision'
            ],

            // " aa "
            // "  bb"
            [
                [[2, 3], [3, 4]],
                [1, 3],
                [2, 4],
                'Right side collision'
            ],

            // " aa "
            // " bb "
            [
                [],
                [1, 3],
                [1, 3],
                'Nested collision'
            ],
        ];
    }
    
    private function assertArrayEquals($expected, $actual, $message = '')
    {
        $this->assertSame(json_encode($expected), json_encode($actual), $message);
    }

    private function getSimpleMock($className, array $methods = [])
    {
        return $this->getMock($className, $methods, [], '', false, false, true, false);
    }
}
