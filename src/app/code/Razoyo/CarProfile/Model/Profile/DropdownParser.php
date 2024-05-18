<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Profile;

/**
 * Filters the dropdown menu choices (Year/Make/Model) on the car profile edit page
 * based on the cars API response and the dropdown values selected by the user
 */
class DropdownParser
{
    /**
     * @param array $carList
     * @return array
     */
    public function parseYears(array $carList): array
    {
        $uniqueYears = array_column($carList, 'year');
        sort($uniqueYears);

        return array_unique($uniqueYears);
    }

    /**
     * @param string $selectedYear
     * @param array $carList
     * @return array
     */
    public function parseMakes(
        string $selectedYear,
        array $carList
    ): array {
        $makes = [];
        foreach ($carList as $car) {
            if ($car['year'] == $selectedYear) {
                $makes[] = $car['make'];
            }
        }
        $filteredMakes = array_unique($makes);
        sort($filteredMakes);

        return $filteredMakes;
    }

    /**
     * @param string $selectedMake
     * @param string $selectedYear
     * @param array $carList
     * @return array
     */
    public function parseModelsAndIds(
        string $selectedMake,
        string $selectedYear,
        array $carList
    ): array {
        $models = [];
        foreach ($carList as $car) {
            if ($car['year'] == $selectedYear) {
                if ($car['make'] == $selectedMake) {
                    $models[] = [
                        'model' => $car['model'],
                        'id' => $car['id']
                    ];
                }
            }
        }

        usort($models, function ($a, $b) {
            return [$a['model'], $a['id']]
                <=>
                [$b['model'], $b['id']];
        });

        return $models;
    }
}
