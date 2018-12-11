Feature: Basket management
  In order to use basket
  As a user
  I need to add and remove items

  Scenario: Add item to the basket
    Given I have empty basket
    When I add item to this basket
    Then Basket should contain one item

  Scenario: Add several items to the basket
    Given I have empty basket
    When I add item with name "first" and price "20 PLN"
    And I add item with name "second" and price "50 PLN"
    Then Basket should contain "2" items
    And Sum of all items in basket should be "70 PLN"

  #Scenario: Remove item from basket