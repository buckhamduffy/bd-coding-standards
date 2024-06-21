<?php

namespace Tests\Rector\TestRector\Fixture;

use Carbon\Carbon;

class TestClass
{
	public function __invoke(): \Carbon\Carbon
	{
		$carbon = $this->getCarbon();
		$carbon2 = \Carbon\Carbon::parse($carbon);
		$carbon3 = $this->getSecondCarbon($carbon2);

		return $carbon3;
	}

	public function getCarbon(?\Carbon\Carbon $carbon = null): \Carbon\Carbon
	{
		return new \Carbon\Carbon($carbon);
	}

	public function getSecondCarbon(\Carbon\Carbon|\DateTimeInterface $carbon)
	{
		return Carbon::parse($carbon);
	}
}

?>
-----
<?php

namespace Tests\Rector\TestRector\Fixture;

use Illuminate\Support\Carbon;

class TestClass
{
	public function __invoke(): Carbon
	{
		$carbon = $this->getCarbon();
		$carbon2 = Carbon::parse($carbon);
		$carbon3 = $this->getSecondCarbon($carbon2);

		return $carbon3;
	}

	public function getCarbon(?Carbon $carbon = null): Carbon
	{
		return new Carbon($carbon);
	}

	public function getSecondCarbon(Carbon|\DateTimeInterface $carbon)
	{
		return Carbon::parse($carbon);
	}
}

?>
