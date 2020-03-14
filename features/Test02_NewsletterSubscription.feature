Feature: Newsletter subscription scenarios
  @javascript
  Scenario: Verify user should be able to subscribe to news letter
    Given I am on homepage
    When I subscribe to newsletter with "random email"
    Then I should be subscribed successfully

  @javascript
  Scenario: Verify error message when already subscribed email is provided
    Given I am on homepage
    When I set a random email
    And I subscribe to newsletter with "email"
    Then I should be subscribed successfully
    When I subscribe to newsletter with "email"
    Then Already subscribed notification should be displayed

  @javascript
  Scenario: Verify error message when subscribed with invalid email
    Given I am on homepage
    When I subscribe to newsletter with "invalid email"
    Then Invalid email is entered message should be displayed