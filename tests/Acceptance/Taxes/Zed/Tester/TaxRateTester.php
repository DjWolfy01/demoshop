<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Acceptance\Taxes\Zed\Tester;

use Acceptance\Taxes\Zed\PageObject\TaxRateCreatePage;
use Acceptance\Taxes\Zed\PageObject\TaxRateListPage;

class TaxRateTester extends \ZedAcceptanceTester
{

    /**
     * @param string $taxRateName
     *
     * @return $this
     */
    public function createTaxRate($taxRateName)
    {
        $i = $this;

        $i->amLoggedInUser();
        $i->amOnPage(TaxRateCreatePage::URL);

        $i->wait(2);

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME,  TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY,  TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE,  TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);

        $i->click(TaxRateCreatePage::SELECTOR_SAVE);
    }

    /**
     * @param string $taxRateName
     *
     * @return $this
     */
    public function createTaxRateWithoutSaving($taxRateName)
    {
        $i = $this;

        $i->amLoggedInUser();
        $i->amOnPage(TaxRateCreatePage::URL);

        $i->wait(2);

        $i->fillField(TaxRateCreatePage::SELECTOR_NAME,  TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->selectOption(TaxRateCreatePage::SELECTOR_COUNTRY,  TaxRateCreatePage::$taxRateData[$taxRateName]['country']);
        $i->fillField(TaxRateCreatePage::SELECTOR_PERCENTAGE,  TaxRateCreatePage::$taxRateData[$taxRateName]['percentage']);
    }

    /**
     * @param string $taxRateName
     *
     * @return $this
     */
    public function searchForTaxRate($taxRateName)
    {
        $i = $this;

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
    }

    /**
     * @param string $taxRateName
     *
     * @return $this
     */
    public function deleteTaxRate($taxRateName)
    {
        $i = $this;

        $i->fillField(TaxRateListPage::SELECTOR_SEARCH, TaxRateCreatePage::$taxRateData[$taxRateName]['name']);
        $i->click(TaxRateListPage::SELECTOR_DELETE);
    }

    /**
     * @return $this
     */
    public function seeErrorMessages()
    {
        $i = $this;

        $i->see(TaxRateCreatePage::ERROR_MESSAGE_NAME_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_COUNTRY_SHOULD_NOT_BE_BLANK);
        $i->see(TaxRateCreatePage::ERROR_MESSAGE_PERCENTAGE_SHOULD_BE_VALID_NUMBER);
    }

}
