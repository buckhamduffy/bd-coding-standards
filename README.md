## BuckhamDuffy Coding Standards & Testing

#### Usage
Run `composer require --dev buckhamduffy/coding-standards`

###### ECS Example
ecs.php
```php
<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Configuration\ECSConfigBuilder;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;

/** @var ECSConfigBuilder $config */
$config = require __DIR__ . '/vendor/buckhamduffy/coding-standards/ecs.php';

$config
    ->withParallel()
    ->withSpacing(indentation: Option::INDENTATION_SPACES, lineEnding: "\n")
    ->withSkip([EmptyStatementSniff::class]);

return $config;

```


###### Rector Example
rector.php
```php
<?php

use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelLevelSetList;
use Rector\Configuration\RectorConfigBuilder;

/** @var RectorConfigBuilder $config */
$config = require __DIR__ . '/vendor/buckhamduffy/coding-standards/rector.php';

$config
    ->withSets([LaravelLevelSetList::UP_TO_LARAVEL_110])
    ->withPhpVersion(PhpVersion::PHP_83)
    ->withPhpSets(php83: true);

return $config;
```

###### PHPStan
phpstan.neon
```neon
includes:
    - ./vendor/buckhamduffy/coding-standards/phpstan.neon
```
