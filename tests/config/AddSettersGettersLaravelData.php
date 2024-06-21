<?php

declare(strict_types=1);

use BuckhamDuffy\CodingStandards\Rector\AddSettersGettersToLaravelData;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
	$rectorConfig->rule(AddSettersGettersToLaravelData::class);
};
