<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Razoyo\CarProfile\Api\Data\ProfilesInterface;

interface ProfilesRepositoryInterface
{
    /**
     * @param string $id
     * @return ProfilesInterface
     */
    public function getById(string $id): Data\ProfilesInterface;

    /**
     * @param ProfilesInterface $profiles
     * @return ProfilesInterface
     */
    public function save(ProfilesInterface $profiles): ProfilesInterface;

    /**
     * @param ProfilesInterface $profiles
     * @return bool
     */
    public function delete(ProfilesInterface $profiles): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \Magento\Framework\Api\SearchResults;
}
