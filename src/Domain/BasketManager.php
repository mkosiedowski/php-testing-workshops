<?php
namespace Domain;

use Exception\BasketNotFoundException;

class BasketManager
{
    private const DEFAULT_CURRENCY = 'PLN';

    /** @var PriceConverter */
    private $priceConverter;

    /** @var Basket */
    private $basket;

    /**
     * BasketManager constructor.
     *
     * @param PriceConverter $priceConverter
     * @param Basket|null    $basket
     */
    public function __construct(PriceConverter $priceConverter, Basket $basket = null)
    {
        $this->priceConverter = $priceConverter;
        $this->basket = $basket;
    }

    /**
     * @param Basket $basket
     */
    public function setBasket(Basket $basket): void
    {
        $this->basket = $basket;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        if (!$this->basket) {
            throw new BasketNotFoundException();
        }

        $this->basket->addItem($item);
    }

    /**
     * @param string $name
     */
    public function removeItem(string $name): void
    {
        if (!$this->basket) {
            throw new BasketNotFoundException();
        }

        $this->basket->removeItem($name);
    }

    /**
     * @return int
     */
    public function countItems(): int
    {
        if (!$this->basket) {
            throw new BasketNotFoundException();
        }

        return count($this->basket->getItems());
    }

    /**
     * @param string $currency
     * @return float
     */
    public function getValue($currency = self::DEFAULT_CURRENCY): float
    {
        if (!$this->basket) {
            throw new BasketNotFoundException();
        }

        return array_reduce($this->basket->getItems(), function (float $value, Item $item) use ($currency) {

            if ($item->getPrice()->getCurrency() !== $currency) {
                $convertedPrice = $this->priceConverter->convert($item->getPrice(), $currency);

                return $value + $convertedPrice->getValue();
            }

            return $value + $item->getPrice()->getValue();
        }, 0);
    }
}
