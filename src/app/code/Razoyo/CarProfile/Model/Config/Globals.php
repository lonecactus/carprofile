<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Config;

/**
 * Single location for module constants for easy editing
 */
class Globals
{
    public const TABLE_PROFILES = 'razoyo_carprofile_profiles';
    public const TABLE_PROFILES_CAR_ID = 'car_id';
    public const TABLE_PROFILES_CREATED_AT = 'created_at';
    public const TABLE_PROFILES_CUSTOMER_ID = 'customer_id';
    public const TABLE_PROFILES_ENTITY_ID = 'entity_id';
    public const TABLE_PROFILES_UPDATED_AT = 'updated_at';

    public const CONFIG_ENABLED = 'razoyo_carprofile/carprofile_config/enabled';

    public const API_ENDPOINT_CARS = 'cars';
    public const API_REQUEST_URI = 'https://exam.razoyo.com/api/';
}
