<?php

namespace Tests\Fixture;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class SomeClass extends Data
{
	public string $firstName;
	public ?string $lastName = null;

	#[DataCollectionOf(MiddleName::class)]
	public DataCollection $middleNames;

	public null|string|Optional $suffix;
	public null|string|Optional $prefix;

	/** @var string[] */
	public array $nickNames = [];

	public bool|Optional $isCool = true;
	public $emptyType;

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function withFirstName($firstName): self
	{
		$this->firstName = $firstName;
		return $this->firstName;
	}
}

?>
-----
<?php

namespace Tests\Fixture;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class SomeClass extends Data
{
	public string $firstName;
	public ?string $lastName = null;

	#[DataCollectionOf(MiddleName::class)]
	public DataCollection $middleNames;

	public null|string|Optional $suffix;
	public null|string|Optional $prefix;

	/** @var string[] */
	public array $nickNames = [];

	public bool|Optional $isCool = true;
	public $emptyType;

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function withFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this->firstName;
	}

 public function getLastName(): ?string
 {
     return $this->lastName;
 }

 public function setLastName(string $lastName): self
 {
     $this->lastName = $lastName;
     return $this;
 }

 /**
  * @return DataCollection<array-key, MiddleName>
  */
 public function getMiddleNames(): DataCollection
 {
     return $this->middleNames;
 }

 /**
  * @param DataCollection<array-key, MiddleName> $middleNames
  */
 public function setMiddleNames(DataCollection|array $middleNames): self
 {
     $this->middleNames = MiddleName::collect($middleNames, DataCollection::class);
     return $this;
 }

 public function getSuffix(): ?string
 {
     return is_string($this->suffix) ? $this->suffix : null;
 }

 public function setSuffix(string $suffix): self
 {
     $this->suffix = $suffix;
     return $this;
 }

 public function getPrefix(): ?string
 {
     return is_string($this->prefix) ? $this->prefix : null;
 }

 public function setPrefix(string $prefix): self
 {
     $this->prefix = $prefix;
     return $this;
 }

 /**
  * @return string[]
  */
 public function getNickNames(): array
 {
     return $this->nickNames;
 }

 /**
  * @param string[] $nickNames
  */
 public function setNickNames(array $nickNames): self
 {
     $this->nickNames = $nickNames;
     return $this;
 }

 public function isCool(): bool
 {
     return is_bool($this->isCool) ? $this->isCool : false;
 }

 public function withIsCool(bool $isCool): self
 {
     $this->isCool = $isCool;
     return $this;
 }

 public function getEmptyType(): mixed
 {
     return $this->emptyType;
 }

 public function setEmptyType(mixed $emptyType): self
 {
     $this->emptyType = $emptyType;
     return $this;
 }
}

?>
