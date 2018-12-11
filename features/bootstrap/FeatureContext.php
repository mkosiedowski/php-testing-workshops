<?php

use Behat\Behat\Context\Context;
use Domain\Basket;
use Domain\BasketManager;
use Domain\Item;
use Domain\Price;
use Assert\Assertion;
use Infrastructure\NBPPriceConverter;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var BasketManager */
    private $basketManager;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->basketManager = new BasketManager(new NBPPriceConverter());
    }

    /**
     * @Given I have empty basket
     */
    public function iHaveEmptyBasket()
    {
        $this->basketManager->setBasket(new Basket());
    }

    /**
     * @When I add item to this basket
     */
    public function iAddItemToThisBasket()
    {
        $item = new Item('some item', new Price(100, 'PLN'));

        $this->basketManager->addItem($item);
    }

    /**
     * @Then Basket should contain one item
     */
    public function basketShouldContainItem()
    {
        Assertion::eq($this->basketManager->countItems(), 1);
    }
}
