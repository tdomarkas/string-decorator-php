<?php

namespace StringDecorator;

use StringDecorator\Decorator\HtmlTagDecorator;
use StringDecorator\Decorator\LinkDecorator;

class StringDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideData
     * @param string $input
     * @param array $indexes
     * @param string $output
     */
    public function testSlicemap($input, $indexes, $output)
    {
        $stringDecorator = StringDecorator::create($input);

        foreach ($indexes as $index) {
            list($start, $end, $tag) = $index;
            
            $stringDecorator->apply($start, $end, HtmlTagDecorator::create($tag));
        }

        $this->assertSame($output, $stringDecorator->render());
    }

    public static function provideData()
    {
        return [
            // single decorator
            [
                'foo bar baz',
                [[4, 7, 'x']],
                'foo <x>bar</x> baz',
            ],
            // unrelated decorators
            [
                'foo bar baz qux',
                [[4, 7, 'x'], [8, 11, 'y']],
                'foo <x>bar</x> <y>baz</y> qux',
            ],
            [
                'foo bar baz',
                [[4, 7, 'x'], [0, 4, 'y']],
                '<y>foo </y><x>bar</x> baz',
            ],
            // nested decorators
            [
                'foo bar baz',
                [[4, 7, 'x'], [4, 7, 'y']],
                'foo <x><y>bar</y></x> baz',
            ],
            [
                'foo bar baz',
                [[4, 7, 'x'], [4, 6, 'y']],
                'foo <x><y>ba</y>r</x> baz',
            ],
            [
                'foo bar baz',
                [[4, 7, 'x'], [5, 6, 'y']],
                'foo <x>b<y>a</y>r</x> baz',
            ],
            [
                'foo bar baz',
                [[4, 7, 'x'], [6, 7, 'y']],
                'foo <x>ba<y>r</y></x> baz',
            ],
            // overlapping decorators
            [
                'foo bar baz qux quux',
                [[8, 15, 'y'], [4, 11, 'x']],
                'foo <x>bar </x><y><x>baz</x> qux</y> quux',
            ],
            [
                'foo bar baz qux quux',
                [[8, 15, 'y'], [4, 11, 'x']],
                'foo <x>bar </x><y><x>baz</x> qux</y> quux',
            ]
        ];
    }

    public function testLinkDecorator()
    {
        $stringDecorator = StringDecorator::create('click here www.example.com');
        $stringDecorator->apply(11, 26, new LinkDecorator());

        $this->assertSame('click here <a href="www.example.com">www.example.com</a>', $stringDecorator->render());
    }

    public function testLinkDecoratorWithHighlighting()
    {
        $stringDecorator = StringDecorator::create('click here www.example.com');
        $stringDecorator->apply(11, 26, new LinkDecorator());
        $stringDecorator->apply(15, 22, HtmlTagDecorator::create('em'));

        $this->assertSame('click here <a href="www.example.com">www.<em>example</em>.com</a>', $stringDecorator->render());
    }

    public function testLinkDecoratorWithOverlappingHighlighting()
    {
        $stringDecorator = StringDecorator::create('click here www.example.com');
        $stringDecorator->apply(11, 26, new LinkDecorator());
        $stringDecorator->apply(6, 22, HtmlTagDecorator::create('em'));

        $this->assertSame('click <em>here </em><a href="www.example.com"><em>www.example</em>.com</a>', $stringDecorator->render());
    }
}
