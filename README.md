Victoire CMS AggregateRating Bundle
============

Need to add a aggregaterating in a victoire cms website ?

First you need to have a valid Symfony2 Victoire edition.
Then you just have to run the following composer command :

```
    php composer.phar require friendsofvictoire/aggregaterating-widget
```

Declare your widget in your AppKernel:

```php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\AggregateRatingBundle\VictoireWidgetAggregateRatingBundle(),
            );

            return $bundles;
        }
    }
```
