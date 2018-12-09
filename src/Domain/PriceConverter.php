<?php

namespace Domain;

interface PriceConverter
{
    /**
     * @param Price  $price
     * @param string $newCurrency
     * @return Price
     */
    public function convert(Price $price, string $newCurrency): Price;
}
