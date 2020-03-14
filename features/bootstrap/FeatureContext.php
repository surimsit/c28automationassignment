<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit\Framework\Assert as assert;
use MinkFieldRandomizer\Filter\FilterEngine;
/**
 * Defines application features from the specific context.
 */
class FeatureContext Extends MinkContext implements Context, SnippetAcceptingContext
{
    private $random_email;

    public function frtFilterValue($value)
    {
        try {
            return (new FilterEngine())->filter($value);
        } catch (Exception $e) {
        }
    }
    /**
* @Given /^wait for the page to load$/
*/
    public function waitForThePageToLoad()
    {
        $this->getSession()->wait('2000');
    }

    /**
     * @When I visit home page
     */
    public function iVisitHomePage()
    {
        $this->visitPath("/");
    }

    /**
     * @When I visit :arg1 with :arg2
     */
    public function iVisitWith($arg1, $arg2)
    {
        $this->visitPath($arg2);
    }

    /**
     * @Then I should see header :status
     * @param $status
     * @throws Exception
     */
    public function iShouldSeeHeader($status)
    {
        $actual_status = json_encode($this->getSession()->getPage()->findById("header")->isVisible());
        assert::assertEquals($actual_status, $status);
    }

    /**
     * @Then I should see footer :status
     * @param $status
     * @throws Exception
     */
    public function iShouldSeeFooter($status=true)
    {
        $actual_status = json_encode($this->getSession()->getPage()->findById("footer")->isVisible());
        assert::assertEquals($actual_status, $status);
    }


    /**
     * @When /^I subscribe to newsletter with "([^"]*)"$/
     */
    public function iSubscribeToNewsletterWith($arg)
    {
        if($arg == "random email")
            $email = $this->frtFilterValue('{RandomEmail}');
        else if($arg == "email")
            $email = $this->random_email;
        else if($arg == "invalid email")
            $email = $this->frtFilterValue('{RandomName}');

        $this->getSession()->getPage()->fillField('newsletter-input', $email);
        $this->getSession()->getPage()->findButton("submitNewsletter")->click();
    }

    public function setFrtMail($frtMail)
    {
        $this->frtMail = $frtMail;
        return $this;
    }

    /**
     * @Then /^I should be subscribed successfully$/
     */
    public function iShouldBeSubscribedSuccessfully()
    {
        $success_status = "Newsletter : You have successfully subscribed to this newsletter.";
        $actual_status =  $this->getSession()->getPage()->find('css', '.alert')->getText();
        assert::assertEquals($actual_status, $success_status);
    }

    /**
     * @Then /^Already subscribed notification should be displayed$/
     */
    public function alreadySubscribedNotificationShouldBeDisplayed()
    {
        $failure_status = "Newsletter : This email address is already registered.";
        $actual_status =  $this->getSession()->getPage()->find('css', '.alert')->getText();
        assert::assertEquals($actual_status, $failure_status);
    }

    /**
     * @When /^I set a random email$/
     */
    public function iSetARandomEmail()
    {
        $this->random_email = $this->frtFilterValue('{RandomEmail}');
    }

    /**
     * @Then /^Invalid email is entered message should be displayed$/
     */
    public function invalidEmailIsEnteredMessageShouldBeDisplayed()
    {
        $failure_status = "Newsletter : Invalid email address.";
        $actual_status =  $this->getSession()->getPage()->find('css', '.alert')->getText();
        assert::assertEquals($actual_status, $failure_status);
    }

    /**
     * @Then /^I should be redirected to the page$/
     */
    public function iShouldBeRedirectedToThePage()
    {
        assert::assertTrue($this->getSession()->getPage()->find('css','#center_column > h1 > span.cat-name')->getText() == "SUMMER DRESSES ");
    }

    /**
     * @When /^I visit women section$/
     */
    public function iVisitWomenSection()
    {
        $this->getSession()->getPage()->find('css','.sf-with-ul')->click();
    }

    /**
     * @Given /^I visit Summer Dresses page$/
     */
    public function iVisitSummerDressesPage()
    {
        $this->waitForThePageToLoad();
        $this->getSession()->getPage()->find('css','#subcategories > ul > li:nth-child(2) > h5 > a ')->click();
        $this->waitForThePageToLoad();
        $this->getSession()->getPage()->find('css','#subcategories > ul > li:nth-child(3) > h5 > a')->click();
    }

    /**
     * @Given /^I login with my credentials$/
     */
    public function iLoginWithMyCredentials()
    {
        $this->getSession()->getPage()->fillField('email', "schirra8@gmail.com");
        $this->getSession()->getPage()->fillField('passwd', "automation123");
        $this->getSession()->getPage()->findButton("SubmitLogin")->click();
    }

    /**
     * @Then /^I should be able to login successfully$/
     */
    public function iShouldBeAbleToLoginSuccessfully()
    {
        assert::assertTrue($this->getSession()->getPage()->find('css','a.account > span')->getText() == "Suresh Chirra");
    }

    /**
     * @Then /^I am on correct product page$/
     */
    public function iAmOnCorrectProductPage()
    {
        assert::assertTrue($this->getSession()->getPage()->find('css','p#product_reference')->getText() == "Model demo_5");
    }

    /**
     * @When /^add product to the cart and proceed to checkout page$/
     */
    public function addProductToTheCartAndProceedToCheckoutPage()
    {
        $this->getSession()->getPage()->findButton("Submit")->click();
        $this->waitForThePageToLoad();
        $this->getSession()->getPage()->find("css","div.button-container > a")->click();
        $this->getSession()->getPage()->find("css","a.button.btn.btn-default.standard-checkout.button-medium")->click();
        $this->getSession()->getPage()->findButton("processAddress")->click();
        $this->getSession()->getPage()->checkField("cgv");
        $this->getSession()->getPage()->findButton("processCarrier")->click();
    }

    /**
     * @Then /^I should be redirected to the payment page$/
     */
    public function iShouldBeRedirectedToThePaymentPage()
    {
        assert::assertTrue($this->getSession()->getPage()->find('css','#center_column > h1')->getText() == "PLEASE CHOOSE YOUR PAYMENT METHOD");
    }

    /**
     * @When /^I pay by check$/
     */
    public function iPayByCheck()
    {
        $this->getSession()->getPage()->find("css","a.cheque")->click();
    }

    /**
     * @Given /^I confirm my order$/
     */
    public function iConfirmMyOrder()
    {
        $this->getSession()->getPage()->find("css","button.btn.btn-default.button-medium")->click();
    }

    /**
     * @Then /^Order should be placed$/
     */
    public function orderShouldBePlaced()
    {
        $success_status = "Your order on My Store is complete.";
        $actual_status =  $this->getSession()->getPage()->find('css', '.alert')->getText();
        assert::assertEquals($actual_status, $success_status);

    }

    /**
     * @When /^I apply filter$/
     */
    public function iApplyFilter()
    {
        $this->getSession()->getPage()->checkField("layered_id_feature_1");
    }

    /**
     * @Then /^Verify number of products are three$/
     */
    public function verifyNumberOfProductsAreThree()
    {
        assert::assertTrue($this->getSession()->getPage()->find("css",".product-count")->gettext(),"Showing 1 - 3 of 3 items");
    }

    /**
     * @Then /^Verify number of products are two$/
     */
    public function verifyNumberOfProductsAreTwo()
    {
        assert::assertTrue($this->getSession()->getPage()->find("css",".product-count")->gettext(),"Showing 1 - 2 of 2 items");
    }

    /**
     * @Then /^Verify first product price as "([^"]*)"$/
     */
    public function verifyFirstProductPriceAs($arg1)
    {
        assert::assertTrue($this->getSession()->getPage()->find("css","#center_column > ul > li.ajax_block_product.col-xs-12.col-sm-6.col-md-4.first-in-line.last-line.first-item-of-tablet-line.first-item-of-mobile-line.last-mobile-line > div > div.right-block > div.content_price > span.price.product-price")->gettext()==$arg1);
    }

    /**
     * @Given /^I apply sorting$/
     */
    public function iApplySorting()
    {
       # $this->getSession()->getPage()->findField("selectProductSort")->click();
        $this->getSession()->getPage()->find("css","#selectProductSort > option:nth-child(3)")->click();
    }
}

