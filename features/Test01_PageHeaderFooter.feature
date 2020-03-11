Feature: search several pages of the site
    @javascript
    Scenario Outline: Verify user should be able to see header and footer on home page
        Given I am on homepage
        When I visit <page> with <URL>
        And wait for the page to load
        Then I should see header <status>
        Then I should see footer <status>
    Examples:
        | page              | URL                                                       | status    |
        | "Home Page"       | "/"                                                       | "True"    |
        | "Contact Page"    | "/?controller=contact"                                    | "False"    |
        | "Test Page"       | "/sdfgh"                                                  | "True"   |
        | "Sign in Page"    | "/index.php?controller=authentication&back=my-account"    | "True"    |
        | "Cart Page"       | "/index.php?controller=order"                             | "True"    |