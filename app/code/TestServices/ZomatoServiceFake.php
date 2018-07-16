<?php

namespace MyApp\TestServices;

use MyApp\Services\ZomatoService;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class ZomatoServiceFake extends ZomatoService
{

    /**
     * Set of mock data to generate search result from. We will define using
     * yml just to keep it clean.
     *
     * @var array
     */
    private static $mock_data = [];

    /**
     * Can use this to prevent client being initialised.
     *
     * @param string $apiKey
     */
    public function __construct()
    {

    }

    /**
     * Mock the returned data.
     *
     * @return ArrayList
     */
    public function search($keyword, $limit = 10)
    {
        $list = new ArrayList();

        foreach (Config::inst()->get(self::class, 'mock_data') as $restaurant) {
            $list->push(new ArrayData([
                'Title' => $restaurant['Title'],
                'Url' => $restaurant['Url'],
                'Address' => $restaurant['Address'],
                'Rating' => $restaurant['Rating'],
                'Votes' => $restaurant['Votes'],
            ]));
        }

        return $list;
    }

}
