## BuckhamDuffy Coding Standards & Testing

#### Usage
- `composer require buckhamduffy/coding-standards`

###### ECS
ecs.php
```php
<?php
return require('vendor/buckhamduffy/coding-standards/ecs.php');
```


###### Rector
rector.php
```php
<?php
return require('vendor/buckhamduffy/coding-standards/rector.php');
```

###### PHPStan
phpstan.neon
```neon
includes:
    - ./vendor/buckhamduffy/coding-standards/phpstan.neon
```