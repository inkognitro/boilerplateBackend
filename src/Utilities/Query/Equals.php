<?php declare(strict_types=1);

namespace App\Utilities\Query;

final class Equals implements Condition
{
    private $attribute;
    private $value;

    /** @param $value mixed */
    public function __construct(string $attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getValue(): string
    {
        return $this->attribute;
    }
}