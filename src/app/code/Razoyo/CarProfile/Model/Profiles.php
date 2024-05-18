<?php


declare(strict_types=1);

namespace Razoyo\CarProfile\Model;

use Razoyo\CarProfile\Api\Data\ProfilesInterface;
use Razoyo\CarProfile\Model\ResourceModel\Profiles as ProfilesResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;
use Razoyo\CarProfile\Model\Config\Globals;

class Profiles extends AbstractExtensibleModel implements ProfilesInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ProfilesResourceModel::class);
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return parent::getData(Globals::TABLE_PROFILES_ENTITY_ID);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return parent::getData(Globals::TABLE_PROFILES_CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     * @return Profiles
     */
    public function setCustomerId(int $customerId): Profiles
    {
        return $this->setData(Globals::TABLE_PROFILES_CUSTOMER_ID, $customerId);
    }

    /**
     * @return string
     */
    public function getCarId(): string
    {
        return parent::getData(Globals::TABLE_PROFILES_CAR_ID);
    }

    /**
     * @param string $carId
     * @return Profiles
     */
    public function setCarId(string $carId): Profiles
    {
        return $this->setData(Globals::TABLE_PROFILES_CAR_ID, $carId);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return parent::getData(Globals::TABLE_PROFILES_CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return Profiles
     */
    public function setCreatedAt(string $createdAt): Profiles
    {
        return parent::setData(Globals::TABLE_PROFILES_CREATED_AT, $createdAt);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return parent::getData(Globals::TABLE_PROFILES_UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return Profiles
     */
    public function setUpdatedAt(string $updatedAt): Profiles
    {
        return parent::setData(Globals::TABLE_PROFILES_UPDATED_AT, $updatedAt);
    }
}
