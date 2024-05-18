<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model;

use Magento\Framework\Api\SearchResults;
use Razoyo\CarProfile\Api\Data;
use Razoyo\CarProfile\Api\Data\ProfilesInterface;
use Razoyo\CarProfile\Api\Data\ProfilesSearchResultInterface;
use Razoyo\CarProfile\Api\Data\ProfilesSearchResultInterfaceFactory;
use Razoyo\CarProfile\Api\ProfilesRepositoryInterface;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResource;
use Razoyo\CarProfile\Model\ResourceModel\Profiles\CollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProfilesRepository implements ProfilesRepositoryInterface
{

    /**
     * @var ProfilesFactory
     */
    protected ProfilesFactory $profilesFactory;
    /**
     * @var ProfilesResource
     */
    protected ProfilesResource $profilesResource;
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $profilesCollectionFactory;
    /**
     * @var ProfilesSearchResultInterfaceFactory
     */
    protected ProfilesSearchResultInterfaceFactory $profilesSearchResultInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @param ProfilesFactory $profilesFactory
     * @param ProfilesResource $profilesResource
     * @param CollectionFactory $profilesCollectionFactory
     * @param ProfilesSearchResultInterfaceFactory $profilesSearchResultInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ProfilesFactory $profilesFactory,
        ProfilesResource $profilesResource,
        CollectionFactory $profilesCollectionFactory,
        ProfilesSearchResultInterfaceFactory $profilesSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->profilesFactory = $profilesFactory;
        $this->profilesResource = $profilesResource;
        $this->profilesCollectionFactory = $profilesCollectionFactory;
        $this->profilesSearchResultInterfaceFactory = $profilesSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param string $id
     * @return ProfilesInterface
     * @throws NoSuchEntityException
     */
    public function getById(string $id): ProfilesInterface
    {
        $profile = $this->profilesFactory->create();
        $this->profilesResource->load($profile, $id);
        if (!$profile->getId()) {
            throw new NoSuchEntityException(__('Unable to find Car Profile with ID "%1"', $id));
        }
        return $profile;
    }

    /**
     * @param ProfilesInterface $profiles
     * @return ProfilesInterface
     * @throws AlreadyExistsException
     */
    public function save(ProfilesInterface $profiles): ProfilesInterface
    {
        $this->profilesResource->save($profiles);
        return $profiles;
    }

    /**
     * @param ProfilesInterface $profiles
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProfilesInterface $profiles): bool
    {
        try {
            $this->profilesResource->delete($profiles);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the Product Agreement entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \Magento\Framework\Api\SearchResults
    {
        $collection = $this->profilesCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->profilesSearchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
