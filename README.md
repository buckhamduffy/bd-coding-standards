## BuckhamDuffy Coding Standards & Testing

#### Usage
Add the following to your composer.json

```
  "repositories": [
    {
      "type": "composer",
      "url": "https://buckhamduffy.github.io/composer/"
    },
    {
      "type": "composer",
      "url": "https://packagist.org"
    }
  ],
```

Run `composer require --dev buckhamduffy/coding-standards`

###### ECS
ecs.php
```php
<?php

use ECSPrefix202207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $containerConfigurator): void {
	$containerConfigurator->import(__DIR__ . '/vendor/buckhamduffy/coding-standards/ecs.php');

};
```


###### Rector
rector.php
```php
<?php

use RectorPrefix202207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
	$containerConfigurator->import(__DIR__ . '/vendor/buckhamduffy/coding-standards/rector.php');
};
```

###### PHPStan
phpstan.neon
```neon
includes:
    - ./vendor/buckhamduffy/coding-standards/phpstan.neon
```