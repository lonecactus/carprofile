<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProfilesSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ProfilesInterface[]
     */
    public function getItems();

    /**
     * @param ProfilesInterface[] $items
     * @return ProfilesSearchResultInterface
     */
    public function setItems(array $items): ProfilesSearchResultInterface;
}
