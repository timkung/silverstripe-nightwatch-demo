<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\Requirements;

class PageController extends ContentController
{
    /**
     * An array of actions that can be accessed via a request. Each array
     * element should be an action name, and the permissions or conditions
     * required to allow the user to access it.
     *
     * @var array
     */
    private static $allowed_actions = [];

    /**
     * @return void
     */
    protected function init()
    {
        parent::init();

        // pull in theme styles
        Requirements::css('themes/base/dist/main.css');
    }
}
