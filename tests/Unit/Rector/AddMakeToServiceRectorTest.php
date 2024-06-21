<?php

namespace Tests\Unit\Rector;

use Rector\Testing\PHPUnit\AbstractRectorTestCase;

class AddMakeToServiceRectorTest extends AbstractRectorTestCase
{
	public function testAdd(): void
	{
		$this->doTestFile(
			__DIR__ . '/../../Fixture/AddMakeToServiceRector.php.inc'
		);
	}

	public function testUpdate()
	{
		$this->doTestFile(
			__DIR__ . '/../../Fixture/UpdateMakeToServiceRector.php.inc'
		);
	}

	public function testSkip()
	{
		$this->doTestFile(
			__DIR__ . '/../../Fixture/DoesntAddMakeToServiceRector.php.inc'
		);
	}

	public function provideConfigFilePath(): string
	{
		return __DIR__ . '/../../config/AddMakeToServiceRector.php';
	}
}
