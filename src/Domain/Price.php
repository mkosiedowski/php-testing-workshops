<?php

namespace Domain;

class Price
{
    /** @var float */
    private $value;

    /** @var string */
    private $currency;

    /**
     * Price constructor.
     *
     * @param float $value
     * @param string $currency
     */
    public function __construct(float $value, string $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
