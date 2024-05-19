# Mage2 Module Razoyo CarProfile

    ``razoyo/module-carprofile``

- [Main Functionalities](#markdown-header-main-functionalities)
- [Configuration](#markdown-header-configuration)
- [Installation](#markdown-header-installation)


## Main Functionalities
Allows a customer to choose from a pre-determined list of cars and save the selection to their customer profile.

When a customer has logged into their Magento account, they will be able to see a link called "My Car Profile" in their account dashboard sidebar. Clicking this link will take them to the route `carprofile/profile/index` which will display information about a car that they have saved to their customer profile.

At first, this information will be blank and will show only default/boilerplate generic information, as they need to create a profile before there is anything to display.

![carprofile_profile_index - new](https://github.com/lonecactus/carprofile/assets/46927805/faadeebc-13aa-45c7-9834-22040fcfa4bb)

There is an Edit button which will navigate the customer to the `carprofile/profile/edit` route, which will allow them to save a new car to their profile (or update their existing profile. The Edit page shows information about any car currently associated with their profile, and also shows a series of dropdown menus that will allow them to select a car from the Cars API by choosing its Year > Make > Model. The customer will only be able to save a car if they have fully selected a specific car from all 3 dropdowns, or else the Save Car button will remain disabled. 

![carprofile_profile_edit - new](https://github.com/lonecactus/carprofile/assets/46927805/68d0105a-27e7-4a8f-918d-00ac500717cf)

Once the customer has clicked Save Car, they will be redirected back to the `carprofile/profile/index` page which will now display all of the information that is available about their chosen car, which is also now saved to the Magento database. A success message will appear at the top of the page to notify them that this has been done.

![carprofile_profile_index - saved success](https://github.com/lonecactus/carprofile/assets/46927805/5ebc91c1-6288-4d48-a3ec-7fe3d106e7d0)

If a customer already has a car associated with their account, `carprofile/profile/index` will initially display the info about that car and the customer can edit the car at any time. 

![carprofile_profile_edit - update existing](https://github.com/lonecactus/carprofile/assets/46927805/56b378d1-055d-4f1a-b0f6-5ffb0b7e7021)


## Configuration
One configuration option is currently available for this module. It is located in the admin at `Stores > Configuration > Razoyo > Car Profile` and is the option to enable or disable the module's visibility on the frontend of the store. Setting the module to Disabled will suppress all links or pages related to this module on the frontend (for instance, the link in the Customer Account sidebar to view the customer's car profile) but will allow the module to remain enabled at the system level in case information needs to be accessed in the backend.

![carprofile config](https://github.com/lonecactus/carprofile/assets/46927805/308d4ea4-0c45-4d0f-8934-183e0fbdd932)


## Installation
\* = in production please use the `--keep-generated` option

- Place the code in `app/code/Razoyo`
- Enable the module by running `php bin/magento module:enable Razoyo_CarProfile`
- Apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`
