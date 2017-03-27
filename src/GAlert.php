<?php

namespace Netcore\GAlerts;

class GAlert extends GAlertBase
{

    /**
     * Get all alerts
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return app(Manager::class)->all();
    }

    /**
     * Find alert by id
     *
     * @param int $id
     * @return \Netcore\GAlerts\GAlert
     */
    public static function findById($id)
    {
        $alerts = app(Manager::class)->all();

        return $alerts->where('id', $id)->first();
    }

    /**
     * Find alert by keyword|query
     *
     * @param string $keyword
     * @return \Netcore\GAlerts\GAlert
     */
    public static function findByKeyword($keyword)
    {
        $alerts = app(Manager::class)->all();

        return $alerts->where('query', $keyword)->first();
    }

    /**
     * Find by data id
     *
     * @param string $id
     * @return \Netcore\GAlerts\GAlert
     */
    public static function findByDataId($id)
    {
        $alerts = app(Manager::class)->all();

        return $alerts->where('dataId', $id)->first();
    }

    /**
     * Delete alert
     *
     * @return bool
     */
    public function delete()
    {
        return (bool) app(Manager::class)->delete($this);
    }

    /**
     * Set query
     *
     * @param $keyword
     * @return $this
     */
    public function keyword($keyword)
    {
        $this->query = $keyword;

        return $this;
    }

    /**
     * Set delivery to feed
     *
     * @return $this
     */
    public function deliverToFeed()
    {
        $this->deliverTo = self::DELIVERY_FEED;

        return $this;
    }

    /**
     * Set delivery to email
     *
     * @return $this
     */
    public function deliverToEmail()
    {
        $this->deliverTo = self::DELIVERY_EMAIL;

        return $this;
    }

    /**
     * Set frequency to "As it happens"
     *
     * @return $this
     */
    public function frequencyAsItHappens()
    {
        $this->howOften = self::FREQUENCY_AS_IT_HAPPENS;

        return $this;
    }

    /**
     * Set frequency to daily (only if delivery = email)
     *
     * @return $this
     */
    public function frequencyDaily()
    {
        $this->howOften = self::FREQUENCY_DAILY;

        return $this;
    }

    /**
     * Set frequency to weekly (only if delivery = email)
     *
     * @return $this
     */
    public function frequencyWeekly()
    {
        $this->howOften = self::FREQUENCY_WEEKLY;

        return $this;
    }

    /**
     * Set language
     *
     * @param $iso
     * @return $this
     */
    public function language($iso)
    {
        $this->language = $iso;

        return $this;
    }

    /**
     * Set "How many" to All results
     *
     * @return $this
     */
    public function allResults()
    {
        $this->howMany = self::QUANTITY_ALL;

        return $this;
    }

    /**
     * Set "How many" to Best only results
     *
     * @return $this
     */
    public function bestResults()
    {
        $this->howMany = self::QUANTITY_BEST;

        return $this;
    }

    /**
     * Create the alert
     * 
     * @return mixed
     */
    public function save()
    {
        $alert = app(Manager::class)->create($this);
        $id = array_get($alert, '4.0.1');

        // Dirty, but works..
        app(Manager::class)->refreshData();

        return self::findByDataId($id);
    }

    /**
     * Update the alert
     *
     * @return $this
     */
    public function update()
    {
        $alert = app(Manager::class)->update($this);
        $id = array_get($alert, '4.0.1');

        // Dirty, but works..
        app(Manager::class)->refreshData();

        return self::findByDataId($id);
    }

    /**
     * Get alert RSS data
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFeedData()
    {
        return app(Manager::class)->getRssData($this);
    }

}