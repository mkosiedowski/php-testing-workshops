Feature: Basket management
  In order to use basket
  As a user
  I need to add and remove items

  Scenario: Add item to the basket
    Given I have empty basket
    When I add item to this basket
    Then Basket should contain one item