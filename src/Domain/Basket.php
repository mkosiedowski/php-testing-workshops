<?php
namespace Domain;

class Basket
{
    /** @var Item[] */
    private $items;

    /**
     * Basket constructor.
     *
     * @param Item[] $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param string $name
     */
    public function removeItem(string $name): void
    {
        $this->items = array_filter($this->items, function (Item $item) use ($name) {
            return $item->getName() !== $name;
        });
    }
}
