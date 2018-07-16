<?php

namespace MyApp\Controllers;

use PageController;
use MyApp\Services\ZomatoService;

use SilverStripe\Core\Convert;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;

class RestaurantPageController extends PageController
{
    /**
     * An array of actions that can be accessed via a request. Each array
     * element should be an action name, and the permissions or conditions
     * required to allow the user to access it.
     *
     * @var array
     */
    private static $allowed_actions = [
        'RestaurantForm',
    ];

    /**
     * Basic form for users to find nearby restaurants based on a food type
     * that they specify.
     *
     * @return Form
     */
    public function RestaurantForm()
    {
        $fields = FieldList::create(
            TextField::create('Keyword', 'Food type')
        );

        $actions = FieldList::create(
            FormAction::create('doRestaurantSearch', 'Find')
        );

        $form = Form::create($this, __FUNCTION__, $fields, $actions);
        $form->setFormMethod('GET');
        $form->loadDataFrom($_GET);

        return $form;
    }

    /**
     * Form submission handler to lookup restaurants based on the foot type the
     * user enters.
     *
     * @param array $data
     * @param Form $form
     *
     * @return string
     */
    public function doRestaurantSearch($data, $form)
    {
        $results = false;

        // extract user query
        $keywords = !empty($data['Keyword'])
            ? Convert::raw2xml($data['Keyword'])
            : '';

        $apiKey = Environment::getEnv('ZOMATO_API_KEY');

        // check we have an API key setup
        if (!$apiKey) {
            $form->sessionMessage('Sorry, there was an error.', 'bad');

            return $this->redirectBack();
        }

        // instantiate new service
        $service = Injector::inst()->create(ZomatoService::class, $apiKey);
        $results = $service->search($keywords);

        // render results into template
        return $this->customise([
            'Query' => Convert::raw2xml($data['Keyword']),
            'Results' => $results
        ]);
    }
}
