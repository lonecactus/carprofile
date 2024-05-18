<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Api\Data;

interface ProfilesInterface
{

    /**
     * @return string
     */
    public function getEntityId(): string;

    /**
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * @param int $customerId
     * @return mixed
     */
    public function setCustomerId(int $customerId);

    /**
     * @return string
     */
    public function getCarId(): string;

    /**
     * @param string $carId
     * @return mixed
     */
    public function setCarId(string $carId);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return mixed
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return mixed
     */
    public function setUpdatedAt(string $updatedAt);
}
