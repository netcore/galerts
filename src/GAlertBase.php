<?php

namespace Netcore\GAlerts;

use Illuminate\Support\Fluent;

abstract class GAlertBase extends Fluent
{

    /**
     * Quantity
     */
    const QUANTITY_BEST = 3;
    const QUANTITY_ALL = 2;

    /**
     * Delivery options
     */
    const DELIVERY_EMAIL = 1;
    const DELIVERY_FEED = 2;

    /**
     * Frequency types
     */
    const FREQUENCY_AS_IT_HAPPENS = 1;
    const FREQUENCY_DAILY = 2;
    const FREQUENCY_WEEKLY = 3;

    /**
     * Source types
     */
    const SOURCE_AUTOMATIC = 0;
    const SOURCE_BLOGS = 1;
    const SOURCE_NEWS = 2;
    const SOURCE_WEB = 3;
    const SOURCE_VIDEOS = 5;
    const SOURCE_BOOKS = 6;
    const SOURCE_DISCUSSIONS = 7;

    const REGION_ANYWHERE = 1;

}