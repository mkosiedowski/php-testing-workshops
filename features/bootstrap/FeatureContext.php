<?php

use Behat\Behat\Context\Context;
use Domain\Basket;
use Domain\Item;
use Domain\Price;
use Assert\Assertion;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var Basket */
    private $basket;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have empty basket
     */
    public function iHaveEmptyBasket()
    {
        $this->basket = new Basket();
    }

    /**
     * @When I add item to this basket
     */
    public function iAddItemsToThisBasket()
    {
        $item = new Item('costam', new Price(100, 'PLN'));
        $this->basket->addItem($item);
    }

    /**
     * @Then Basket should contain one item
     */
    public function basketShouldContainItems()
    {
        Assertion::count($this->basket->getItems(), 1);
    }
}
