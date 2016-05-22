# String decorator for PHP

Decorate your string with indexed callbacks:

```php
$compositeDecorator = StringDecorator::create('foo bar baz');
$compositeDecorator->apply(4, 7, HtmlTagDecorator::create('strong'));
$compositeDecorator->apply(0, 7, HtmlTagDecorator::create('em'));
$compositeDecorator->render(); // => "<em>foo </em><strong><em>bar</em></strong> baz"
```

You can apply your own decorators by implementing DecoratorInterface. 

This is an early release. Don't use in production.
