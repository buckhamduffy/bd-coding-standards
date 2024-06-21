<?php

declare(strict_types=1);

namespace Tests\Unit\Rector;

use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class UseLaravelCarbonRectorTest extends AbstractRectorTestCase
{
	public function test(): void
	{
		$this->doTestFile(
			__DIR__ . '/../../Fixture/UseLaravelCarbonRector.php.inc'
		);
	}

	public function provideConfigFilePath(): string
	{
		return __DIR__ . '/../../config/UseLaravelCarbonRector.php';
	}
}
