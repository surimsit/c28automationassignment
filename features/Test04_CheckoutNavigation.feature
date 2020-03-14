Feature: Checkout journey by adding any product to the cart.
  @javascript
  Scenario: Verify the checkout journey by adding any product to the cart.
    Given I am on homepage
    When I visit "login page" with "/index.php?controller=authentication&back=my-account"
    And I login with my credentials
    Then I should be able to login successfully
    When I visit "product page" with "/index.php?id_product=5&controller=product"
    Then I am on correct product page
    When add product to the cart and proceed to checkout page
    Then I should be redirected to the payment page
    When I pay by check
    And I confirm my order
    Then Order should be placed