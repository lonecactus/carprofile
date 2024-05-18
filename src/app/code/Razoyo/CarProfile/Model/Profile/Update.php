<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Profile;

use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Razoyo\CarProfile\Api\ProfilesRepositoryInterface;
use Razoyo\CarProfile\Model\Profiles;
use Razoyo\CarProfile\Model\ProfilesFactory;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResourceModel;

class Update
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
     * @var ProfilesRepositoryInterface
     */
    protected ProfilesRepositoryInterface $profilesRepositoryInterface;

    /**
     * @param ProfilesFactory $profilesFactory
     * @param DateTimeFactory $dateFactory
     * @param ProfilesResourceModel $profilesResourceModel
     * @param ProfilesRepositoryInterface $profilesRepositoryInterface
     */
    public function __construct(
        ProfilesFactory $profilesFactory,
        DateTimeFactory $dateFactory,
        ProfilesResourceModel $profilesResourceModel,
        ProfilesRepositoryInterface $profilesRepositoryInterface
    ) {
        $this->profilesFactory = $profilesFactory;
        $this->dateFactory = $dateFactory;
        $this->profilesResourceModel = $profilesResourceModel;
        $this->profilesRepositoryInterface = $profilesRepositoryInterface;
    }

    /**
     * Update existing car profile record in carprofile database
     *
     * @param string $selectedModelId
     * @param string $currentProfileId
     * @return Profiles
     */
    public function update(
        string $selectedModelId,
        string $currentProfileId
    ): Profiles {
        $now = $this->dateFactory->create()->gmtDate();

        $profile = $this->profilesRepositoryInterface->getById($currentProfileId);
        $profile->setCarId($selectedModelId);
        $profile->setUpdatedAt($now);

        return $profile;
    }
}
