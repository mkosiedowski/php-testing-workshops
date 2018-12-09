<?php
namespace Domain;

class Item
{
    /** @var string  */
    private $name;

    /** @var Price  */
    private $price;

    /**
     * Item constructor.
     *
     * @param string $name
     * @param Price  $price
     */
    public function __construct(string $name, Price $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }
}
