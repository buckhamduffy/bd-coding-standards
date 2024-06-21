<?php

declare(strict_types=1);

use BuckhamDuffy\CodingStandards\Rector\AddMakeToServiceRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
	$rectorConfig->rule(AddMakeToServiceRector::class);
};
