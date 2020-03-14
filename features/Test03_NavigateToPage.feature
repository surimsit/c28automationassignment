Feature: Navigate to Women > Dresses > Summer Dresses listing page and Apply filters and sorting
  @javascript
  Scenario: Verify user should be able to navigate to Women > Dresses > Summer Dresses listing page
    Given I am on homepage
    When I visit women section
    And I visit Summer Dresses page
    Then I should be redirected to the page

  @javascript
  Scenario: Verify page filters after user navigating to Women > Dresses > Summer Dresses listing page and apply filter
    Given I am on homepage
    When I visit women section
    And I visit Summer Dresses page
    Then I should be redirected to the page
    Then Verify number of products are three
    When I apply filter
    Then Verify number of products are two

  @javascript
  Scenario: Verify product sorting after user navigating to Women > Dresses > Summer Dresses listing page and apply sorting
    Given I am on homepage
    When I visit women section
    And I visit Summer Dresses page
    Then I should be redirected to the page
    Then Verify first product price as "$28.98"
    And I apply sorting
    Then Verify first product price as "$30.50"