<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\ResourceModel\Profiles;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Razoyo\CarProfile\Model\Config\Globals;
use Razoyo\CarProfile\Model\Profiles as ProfilesModel;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResourceModel;

class Collection extends AbstractCollection
{

    protected $_idFieldName = Globals::TABLE_PROFILES_ENTITY_ID;

    /**
     * @return void
     */
    public function _construct(): void
    {
        $this->_init(ProfilesModel::class, ProfilesResourceModel::class);
    }
}
