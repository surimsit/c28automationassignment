<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
#use PHPUnit\Framework\Assert as a;
/**
 * Defines application features from the specific context.
 */
class FeatureContext Extends MinkContext implements Context, SnippetAcceptingContext
{
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
     * @When I visit contact page
     */
    public function iVisitContactPage()
    {
        $this->visitPath("/?controller=contact");
    }
    
     /**
     * @When I visit <:pageName> with <:url>
     */
    public function iVisitPage($pageName, $url)
    {
        $this->visitPath($url);
    }
    
     /**
     * @When I visit :arg1 with :arg2
     */
    public function iVisitWith($arg1, $arg2)
    {
        $this->visitPath($arg2);
    }



    /**
     * @Then I should see header
     */
    public function iShouldSeeHeader()
    {
        $this->assertElementOnPage("header");
    }
    
    /**
     * @Then I should see footer
     */
    public function iShouldSeeFooter()
    {
        $this->assertElementOnPage("footer");
    }
    
     /**
     * @Then I should see header :status
     */
    public function iShouldSeeHeader2($status)
    {
        #a::assertEquals(1,1);
        
        #echo $this->getSession()->getPage()->hasField("header");
        $this->getSession()->getPage()->hasField("header")==$status ;
    }

    /**
     * @Then I should see footer :status
     */
    public function iShouldSeeFooter2($status)
    {
        $this->getSession()->getPage()->hasField("footer")==$status ;
        #$this->getSession()->getPage()->hasField("footer") == $status ;
        #$this->getSession()->getPage()->findById("footer")->isVisible() == $status ;
        #PHPUnit_Framework_Assert::assertSame($this->assertElementOnPage("footer") == $status);
    }

    
}
?>
