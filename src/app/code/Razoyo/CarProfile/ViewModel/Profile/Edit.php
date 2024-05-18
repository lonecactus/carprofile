<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\ViewModel\Profile;

use Magento\Customer\Model\Session;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Razoyo\CarProfile\Model\Config\Globals;
use Razoyo\CarProfile\Model\Profile\DropdownParser;
use Razoyo\CarProfile\Service\ApiService;

class Edit extends DataObject implements ArgumentInterface
{
    /**
     * @var ApiService
     */
    protected ApiService $apiService;
    /**
     * @var Session
     */
    protected Session $customerSession;
    /**
     * @var DropdownParser
     */
    protected DropdownParser $dropdownParser;

    /**
     * @param ApiService $apiService
     * @param Session $customerSession
     * @param DropdownParser $dropdownParser
     */
    public function __construct(
        ApiService $apiService,
        Session $customerSession,
        DropdownParser $dropdownParser
    ) {
        parent::__construct();
        $this->apiService = $apiService;
        $this->customerSession = $customerSession;
        $this->dropdownParser = $dropdownParser;
    }

    /**
     * Query the cars API endpoint for all cars available in the list
     * and save it to the session for repeat usage
     *
     * @return array
     */
    public function getCarListFromApi(): array
    {
        $carList = $this->apiService->execute(Globals::API_ENDPOINT_CARS);

        // save carList to session for later access without costing additional API queries
        $this->customerSession->setCarList($carList['cars']);

        return $carList['cars'];
    }

    /**
     * Retrieve saved or default car information from session
     *
     * @see \Razoyo\CarProfile\ViewModel\Profile\Index
     * @return array|null
     */
    public function getSavedCarInfo(): ?array
    {
        return $this->customerSession->getSavedCarInfo();
    }

    /**
     * Filter all years returned from cars API into a dropdown for the template
     *
     * @param array $carList
     * @return array
     */
    public function getYears(array $carList): array
    {
        return $this->dropdownParser->parseYears($carList);
    }
}
