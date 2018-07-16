<?php

namespace MyApp\Services;

use GuzzleHttp\Client;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class ZomatoService
{

    /**
     * The endpoint for the Zomato API.
     *
     * @var string
     */
    const BASE_API_URI = 'https://developers.zomato.com/api/v2.1/';

    /**
     * The default maximum amount of restaurants to return when searching
     * for them.
     *
     * @var int
     */
    const DEFAULT_RESTAURANT_LIMIT = 10;

    /**
     * The API key to use to make the calls.
     *
     * @var string
     */
    private $apiKey = null;

    /**
     * Helper to provide access to a GuzzleHttp\Client.
     *
     * @var GuzzleHttp\Client
     */
    private $client = null;

    /**
     * Setup the API key on creation.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        if (!$apiKey) {
            throw new Exception('You need to pass in an apiKey');
        }

        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => self::BASE_API_URI,
            'timeout' => 2.0
        ]);
    }

    /**
     * Use to search for a restaurant on Zomato based on a keyword and sort by
     * user ratings.
     *
     * @param string $keyword
     * @param integer $limit
     *
     * @return ArrayList|null
     */
    public function search($keyword, $limit = self::DEFAULT_RESTAURANT_LIMIT)
    {
        $result = new ArrayList();

        try {
            $response = $this->client->request('GET', 'search', [
                'headers' => [
                    'Accept' => 'application/json',
                    'user-key' => $this->apiKey
                ],
                'query' => [
                    'q' => $keyword,
                    'count' => $limit,
                    'sort' => 'rating'
                ]
            ]);
        } catch (RequestException $e) {
            return null;
        }

        // ensure response is ok
        if ($response->getStatusCode() == 200) {
            $body = (string) $response->getBody();

            // attempt to decode the response
            $results = json_decode($body);

            // cancel here if no restaurants returned
            if (!$results || !isset($results->restaurants)) {
                return null;
            }

            // otherwise add found restaurant data to the result list
            foreach ($results->restaurants as $restaurant) {
                $data = $restaurant->restaurant;

                $result->push(new ArrayData([
                    'Title' => $data->name,
                    'Url' => $data->url,
                    'Address' => $data->location->address,
                    'Rating' => $data->user_rating->aggregate_rating,
                    'Votes' => $data->user_rating->votes
                ]));
            }
        }

        return $result;
    }

}
