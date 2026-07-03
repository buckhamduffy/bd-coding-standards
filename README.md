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
    ->withSpacing(indentation: Option::INDENTATION_SPACES, lineEnding: "\n");

return $config;
```

###### PHPStan
phpstan.neon
```neon
includes:
    - ./vendor/buckhamduffy/coding-standards/extension.neon
```

###### CaptainHook
CaptainHook can be used to install custom made commit hooks
```bash
composer require --dev captainhook/hook-installer
```
```bash
cp vendor/buckhamduffy/coding-standards/captainhook.json captainhook.json
```
