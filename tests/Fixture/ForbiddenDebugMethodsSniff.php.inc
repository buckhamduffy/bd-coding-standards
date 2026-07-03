<?php

class ForbiddenDebugMethodsFixture
{
	public function violations($query, $collection): void
	{
		Candidate::query()->ds()->get(); // forbidden
		Candidate::query()?->dump()->get(); // forbidden
		$query->dd(); // forbidden
		$collection->ray(); // forbidden
		$query->DS(); // forbidden
		$query
			->ds() // forbidden
			->get();
	}

	public function allowed($query): void
	{
		ds($query);
		$query->dsSomething();
		$query->dumpAndDie;
		$query->keepMe();
		$this->ds;
	}

	public function ds(): void
	{
	}
}
