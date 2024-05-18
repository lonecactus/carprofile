<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\ViewModel\Profile;

use Magento\Customer\Model\Session;
use Magento\Framework\DataObject;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Razoyo\CarProfile\Model\Config\Globals;
use Razoyo\CarProfile\Model\Profile\Lookup as LookupProfile;
use Razoyo\CarProfile\Service\ApiService;

class Index extends DataObject implements ArgumentInterface
{
    /**
     * @var LookupProfile
     */
    protected LookupProfile $lookupProfile;
    /**
     * @var Session
     */
    protected Session $customerSession;
    /**
     * @var ApiService
     */
    protected ApiService $apiService;
    /**
     * @var AssetRepository
     */
    protected AssetRepository $assetRepo;

    /**
     * @param LookupProfile $lookupProfile
     * @param Session $customerSession
     * @param ApiService $apiService
     * @param AssetRepository $assetRepo
     */
    public function __construct(
        LookupProfile   $lookupProfile,
        Session         $customerSession,
        ApiService      $apiService,
        AssetRepository $assetRepo
    ) {
        parent::__construct();
        $this->lookupProfile = $lookupProfile;
        $this->customerSession = $customerSession;
        $this->apiService = $apiService;
        $this->assetRepo = $assetRepo;
    }

    /**
     * Return information about the car associated with the user's saved profile
     * or default information if they do not have a profile yet
     *
     * @return array|null
     */
    public function getSavedCar(): ?array
    {
        $customerId = (int)$this->customerSession->getCustomerId();
        $profileSearchResults = $this->lookupProfile->lookup($customerId);
        $profiles = $profileSearchResults->getItems();

        if (count($profiles) === 0) {
            $defaultCar = [];
            $carInfo = $this->parseCarInfo($defaultCar);
        } elseif (count($profiles) === 1) {
            $currentProfile = reset($profiles);
            $currentProfileCarId = $currentProfile->getCarId();
            $vehicleInfoRequest = $this->getCarInfoFromApi($currentProfileCarId);
            $carInfo = $this->parseCarInfo($vehicleInfoRequest);
        }

        $this->customerSession->setSavedCarInfo($carInfo);
        return $carInfo;
    }

    /**
     * Get car info for specific model from the cars API endpoint
     *
     * @param string $carId
     * @return array
     */
    public function getCarInfoFromApi(string $carId): array
    {
        $vehicleInfoApiEndpoint = Globals::API_ENDPOINT_CARS . '/' . $carId;
        $currentVehicleRequest = $this->apiService->execute($vehicleInfoApiEndpoint);

        return $currentVehicleRequest['car'];
    }

    /**
     * Populate an array with values used in the template for the selected car
     *
     * @param array $car
     * @return array
     */
    public function parseCarInfo(array $car): array
    {
        $carInfo = [];

        $carInfo['image'] = (array_key_exists('image', $car))
            ? $car['image']
            : $this->assetRepo->getUrl('Razoyo_CarProfile::images/default.png');
        $carInfo['year'] = (array_key_exists('year', $car)) ? $car['year'] : 'N/A';
        $carInfo['make'] = (array_key_exists('make', $car)) ? $car['make'] : 'N/A';
        $carInfo['model'] = (array_key_exists('model', $car)) ? $car['model'] : 'N/A';
        $carInfo['mpg'] = (array_key_exists('mpg', $car)) ? $car['mpg'] : 'N/A';
        $carInfo['price'] = (array_key_exists('price', $car)) ? '$' . number_format($car['price'], 2) : 'N/A';
        $carInfo['seats'] = (array_key_exists('seats', $car)) ? $car['seats'] : 'N/A';

        return $carInfo;
    }
}
