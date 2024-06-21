<?php

declare(strict_types=1);

namespace Tests\Unit\Rector;

use Rector\Testing\PHPUnit\AbstractRectorTestCase;

class ChangeRequestCallToInputRectorTest extends AbstractRectorTestCase
{
	public function test(): void
	{
		$this->doTestFile(
			__DIR__ . '/../../Fixture/ChangeRequestCallToInputRector.php.inc'
		);
	}

	public function provideConfigFilePath(): string
	{
		return __DIR__ . '/../../config/ChangeRequestCallToInputRector.php';
	}
}
