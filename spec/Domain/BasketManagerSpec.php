<?php

namespace spec\Domain;

use Domain\Basket;
use Domain\Item;
use Domain\Price;
use Domain\PriceConverter;
use Exception\BasketNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument\Token\AnyValueToken;

class BasketManagerSpec extends ObjectBehavior
{
    public function let(PriceConverter $priceConverter, Basket $basket)
    {
        $this->beConstructedWith($priceConverter, $basket);
    }

    public function it_should_throw_exception_when_no_basket(PriceConverter $priceConverter, Item $item)
    {
        $this->beConstructedWith($priceConverter, null);
        $this->shouldThrow(BasketNotFoundException::class)->during('addItem', [$item]);
        $this->shouldThrow(BasketNotFoundException::class)->during('removeItem', ['test']);
        $this->shouldThrow(BasketNotFoundException::class)->during('getValue', ['PLN']);
        $this->shouldThrow(BasketNotFoundException::class)->during('countItems');
    }

    public function it_should_add_item(Basket $basket, Item $item)
    {
        $basket->addItem($item)->shouldBeCalled();
        $this->addItem($item);
    }

    public function it_should_remove_item(Basket $basket)
    {
        $itemName = 'some test name';
        $basket->removeItem($itemName)->shouldBeCalled();
        $this->removeItem($itemName);
    }

    public function it_should_count_items(Basket $basket, Item $item)
    {
        $itemsCount = rand(1, 100);
        $items = array_fill(0, $itemsCount, $item);
        $basket->getItems()->willReturn($items);
        $this->countItems()->shouldBe($itemsCount);
    }

    public function it_should_set_basket(Basket $basket)
    {
        $this->shouldNotThrow(\Throwable::class)->during('setBasket', [$basket]);
    }

    public function it_should_convert_prices_to_get_value(
        PriceConverter $priceConverter,
        Basket $basket,
        Item $item,
        Price $priceEuro,
        Price $priceZloty
    ) {
        $basket->getItems()->willReturn([$item]);
        $item->getPrice()->willReturn($priceZloty);
        $priceZloty->getCurrency()->willReturn('PLN');
        $priceEuro->getValue()->willReturn(1.0);
        $priceConverter->convert($priceZloty, 'EUR')->willReturn($priceEuro);
        $this->getValue('EUR')->shouldBe(1.0);
    }

    public function it_should_use_existing_value(
        PriceConverter $priceConverter,
        Basket $basket,
        Item $item,
        Price $price
    ) {
        $basket->getItems()->willReturn([$item]);
        $item->getPrice()->willReturn($price);
        $price->getValue()->willReturn(2.5);
        $price->getCurrency()->willReturn('EUR');
        $priceConverter->convert(new AnyValueToken(), new AnyValueToken())->shouldNotBeCalled();
        $this->getValue('EUR')->shouldBe(2.5);
    }
}
