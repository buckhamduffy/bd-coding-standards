## BuckhamDuffy Coding Standards & Testing

#### Usage
Run `composer require --dev buckhamduffy/coding-standards`

###### ECS
ecs.php
```php
<?php

use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $config): void {
	$config->import(__DIR__ . '/vendor/buckhamduffy/coding-standards/ecs.php');
};
```


###### Rector
rector.php
```php
<?php

return static function (\Rector\Config\RectorConfig $config): void {
	$config->import(__DIR__ . '/vendor/buckhamduffy/coding-standards/rector.php');
};
```

###### PHPStan
phpstan.neon
```neon
includes:
    - ./vendor/buckhamduffy/coding-standards/phpstan.neon
```
