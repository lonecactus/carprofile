<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Profile;

use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Razoyo\CarProfile\Model\Profiles;
use Razoyo\CarProfile\Model\ProfilesFactory;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResourceModel;

class Create
{
    /**
     * @var ProfilesFactory
     */
    protected ProfilesFactory $profilesFactory;
    /**
     * @var DateTimeFactory
     */
    protected DateTimeFactory $dateFactory;
    /**
     * @var ProfilesResourceModel
     */
    protected ProfilesResourceModel $profilesResourceModel;

    /**
     * @param ProfilesFactory $profilesFactory
     * @param DateTimeFactory $dateFactory
     * @param ProfilesResourceModel $profilesResourceModel
     */
    public function __construct(
        ProfilesFactory $profilesFactory,
        DateTimeFactory $dateFactory,
        ProfilesResourceModel $profilesResourceModel
    ) {
        $this->profilesFactory = $profilesFactory;
        $this->dateFactory = $dateFactory;
        $this->profilesResourceModel = $profilesResourceModel;
    }

    /**
     * Create new car profile record in carprofile database
     *
     * @param int $customerId
     * @param string $selectedModelId
     * @return Profiles
     */
    public function create(
        int $customerId,
        string $selectedModelId
    ): Profiles {
        $now = $this->dateFactory->create()->gmtDate();

        $profile = $this->profilesFactory->create();
        $profile->setCustomerId($customerId);
        $profile->setCarId($selectedModelId);
        $profile->setCreatedAt($now);
        $profile->setUpdatedAt($now);

        return $profile;
    }
}
