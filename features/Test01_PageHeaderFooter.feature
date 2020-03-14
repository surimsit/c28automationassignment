Feature: search several pages of the site
    @javascript
    Scenario Outline: Verify user should be able to see header and footer on home page
        Given I am on homepage
        When I visit <page> with <URL>
        And wait for the page to load
        Then I should see header <status>
        Then I should see footer <status>
    Examples:
        | page              | URL                                                       | status |
        | "Home Page"       | "/"                                                       | true   |
        | "Contact Page"    | "/?controller=contact"                                    | true   |
        | "Sign in Page"    | "/index.php?controller=authentication&back=my-account"    | true   |
        | "Cart Page"       | "/index.php?controller=order"                             | true   |

