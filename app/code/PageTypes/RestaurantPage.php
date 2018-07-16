<?php

namespace MyApp\PageTypes;

use Page;

use MyApp\Controllers\RestaurantPageController;

class RestaurantPage extends Page
{

    /**
     * @var string
     */
    private static $description = 'Used to find local restaurants';

    /**
     * @return string
     */
    public function getControllerName()
    {
        return RestaurantPageController::class;
    }

}
