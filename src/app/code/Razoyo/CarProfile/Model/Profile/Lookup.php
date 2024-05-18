<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Profile;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Razoyo\CarProfile\Model\Config\Globals;
use Razoyo\CarProfile\Model\ProfilesRepository;

class Lookup
{

    /**
     * @var FilterBuilder
     */
    protected FilterBuilder $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    protected FilterGroupBuilder $filterGroupBuilder;

    /**
     * @var ProfilesRepository
     */
    protected ProfilesRepository $profilesRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param ProfilesRepository $profilesRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        ProfilesRepository $profilesRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->profilesRepository = $profilesRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Search Magento car profile database for an existing user/car profile
     *
     * @param int $customerId
     * @return SearchResults
     */
    public function lookup(int $customerId): SearchResults
    {
        $filter = $this->filterBuilder
            ->setField(Globals::TABLE_PROFILES_CUSTOMER_ID)
            ->setValue($customerId)
            ->setConditionType('eq')
            ->create();

        $this->searchCriteriaBuilder->addFilters([$filter]);
        $this->searchCriteriaBuilder->setPageSize(20);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->profilesRepository->getList($searchCriteria);

        return $searchResult;
    }
}
