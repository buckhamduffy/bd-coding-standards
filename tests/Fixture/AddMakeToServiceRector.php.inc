<?php

namespace Tests\Fixture;

use BuckhamDuffy\CodingStandards\Rector\Attributes\Makeable;

#[Makeable]
class SomeService
{
	public function __construct(
		private string $foo,
		private string $bar,
	)
	{
	}

public function foo(): string
{
    return $this->foo;
}

public function bar(): string
{
    return $this->bar;
}
}
?>
-----
<?php

namespace Tests\Fixture;

use BuckhamDuffy\CodingStandards\Rector\Attributes\Makeable;

#[Makeable]
class SomeService
{
	public function __construct(
		private string $foo,
		private string $bar,
	)
	{
	}

 public static function make(string $foo, string $bar): self
 {
     return new self($foo, $bar);
 }

public function foo(): string
{
    return $this->foo;
}

public function bar(): string
{
    return $this->bar;
}
}
?>
