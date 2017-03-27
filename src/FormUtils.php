<?php

namespace Netcore\GAlerts;

use Netcore\GAlerts\Exceptions\GAlertException;

class FormUtils
{
    /**
     * Get form fields
     *
     * @param $data
     * @return array
     * @throws \Netcore\GAlerts\Exceptions\GAlertException
     */
    public static function getFormFields($data)
    {
        if (preg_match('/(<form.*?id=.?gaia_loginform.*?<\/form>)/is', $data, $matches)) {
            return self::getInputs($matches[1]);
        } else {
            throw new GAlertException('Cannot authenticate, bad response from server');
        }
    }

    /**
     * Get form inputs
     *
     * @param $form
     * @return array
     */
    public static function getInputs($form)
    {
        $inputs = [];

        $elements = preg_match_all('/(<input[^>]+>)/is', $form, $matches);

        if ($elements > 0) {
            for ($i = 0; $i < $elements; $i++) {

                $el = preg_replace('/\s{2,}/', ' ', $matches[1][ $i ]);

                if (preg_match('/name=(?:["\'])?([^"\'\s]*)/i', $el, $name)) {
                    $name = $name[1];
                    $value = '';

                    if (preg_match('/value=(?:["\'])?([^"\'\s]*)/i', $el, $value)) {
                        $value = $value[1];
                    }

                    $inputs[ $name ] = $value;
                }
            }
        }

        return $inputs;
    }

    /**
     * Parse alerts
     *
     * @param $data
     * @param $rssBaseEndpoint
     * @return array
     */
    public static function parseAlerts($data, $rssBaseEndpoint)
    {
        $regexp = "(?:<li class=\"alert_instance\" data-id=\"(.*)\">)(.*)(?:<\/li>)";
        $regexp2 = "(?:<span tabindex=\"0\">)(.*)(?:<\/span>)";
        $regexp3 = "<a href=\"([^\"]*)\"(.*)<\/a>";

        $res = [];

        if (preg_match_all("/$regexp/siU", $data, $matches)) {

            $count = 0;

            foreach ($matches[2] as $row) {

                $item = [];

                $item['id'] = $matches[1][ $count ];

                if (strpos($row, 'rss_icon') > 0) {
                    $item['type'] = 'feed';
                } else {
                    $item['type'] = 'email';
                }

                if (preg_match_all("/$regexp2/siU", $row, $cells)) {
                    $item['term'] = $cells[1][0];
                }

                if (preg_match_all("/$regexp3/siU", $row, $cells)) {
                    $item['url'] = $rssBaseEndpoint . $cells[1][0];
                }

                $count++;

                $res[] = $item;
            }
        }

        return $res;
    }

}