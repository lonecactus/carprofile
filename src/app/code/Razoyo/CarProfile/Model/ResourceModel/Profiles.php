<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Razoyo\CarProfile\Model\Config\Globals;

class Profiles extends AbstractDb
{
    /**
     * @return void
     */
    public function _construct(): void
    {
        $this->_init(
            Globals::TABLE_PROFILES,
            Globals::TABLE_PROFILES_ENTITY_ID
        );
    }
}
