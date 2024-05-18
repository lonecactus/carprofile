<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Profile;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Razoyo\CarProfile\Model\Profile\Create as CreateProfile;
use Razoyo\CarProfile\Model\Profile\Lookup as LookupProfile;
use Razoyo\CarProfile\Model\Profile\Update as UpdateProfile;
use Razoyo\CarProfile\Model\ProfilesFactory;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResourceModel;

class Save
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
     * @var Lookup
     */
    protected LookupProfile $lookupProfile;
    /**
     * @var Create
     */
    protected CreateProfile $createProfile;
    /**
     * @var Update
     */
    protected Update $updateProfile;

    /**
     * @param ProfilesFactory $profilesFactory
     * @param DateTimeFactory $dateFactory
     * @param ProfilesResourceModel $profilesResourceModel
     * @param Lookup $lookupProfile
     * @param Create $createProfile
     * @param Update $updateProfile
     */
    public function __construct(
        ProfilesFactory $profilesFactory,
        DateTimeFactory $dateFactory,
        ProfilesResourceModel $profilesResourceModel,
        LookupProfile $lookupProfile,
        CreateProfile $createProfile,
        UpdateProfile $updateProfile
    ) {
        $this->profilesFactory = $profilesFactory;
        $this->dateFactory = $dateFactory;
        $this->profilesResourceModel = $profilesResourceModel;
        $this->lookupProfile = $lookupProfile;
        $this->createProfile = $createProfile;
        $this->updateProfile = $updateProfile;
    }

    /**
     * Determine whether a user already has an existing car profile or not,
     * then update or create a new one accordingly
     *
     * @param int $customerId
     * @param string $selectedModelId
     * @return void
     * @throws AlreadyExistsException
     */
    public function save(
        int $customerId,
        string $selectedModelId
    ): void {
        $profileSearchResults = $this->lookupProfile->lookup($customerId);
        $profiles = $profileSearchResults->getItems();

        if (count($profiles) === 0) {
            $profile = $this->createProfile->create($customerId, $selectedModelId);
            $this->profilesResourceModel->save($profile);
        } elseif (count($profiles) === 1) {
            $currentProfile = reset($profiles);
            $currentProfileId = $currentProfile->getEntityId();
            $profile = $this->updateProfile->update($selectedModelId, $currentProfileId);
            $this->profilesResourceModel->save($profile);
        }
    }
}
