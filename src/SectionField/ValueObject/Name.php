<?php
declare (strict_types=1);

namespace Tardigrades\SectionField\ValueObject;

use Assert\Assertion;

final class Name
{
    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        Assertion::string($name, 'The name has to be a string');

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }
}
