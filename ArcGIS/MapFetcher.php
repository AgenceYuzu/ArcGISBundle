<?php
/**
 * File containing the MapFetcher class.
 *
 * @copyright Copyright (C) 2014 Agence Yuzu. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace Yuzu\ArcGISBundle\ArcGIS;


class MapFetcher
{
    protected $arcgis_client_id;
    protected $arcgis_client_secret;

    public function __construct($arcgis_client_id, $arcgis_client_secret)
    {
        $this->arcgis_client_id = $arcgis_client_id;
        $this->arcgis_client_secret = $arcgis_client_secret;
    }

    public function getToken()
    {
        //ArcGIS Credentials
        $client_id = $this->arcgis_client_id;
        $client_secret = $this->arcgis_client_secret;

        //Generate Token on ArcGIS Online
        $url_token = 'https://www.arcgis.com/sharing/oauth2/token?client_id='.$client_id.'&grant_type=client_credentials&client_secret='.$client_secret.'&f=pjson';

        //Parse JSON and store access_token
        $auth = json_decode( $this->get_json($url_token) );
        $access_token = $auth->{'access_token'};

        return $access_token;
    }

    public function getItemData($itemId)
    {
        $access_token = $this->getToken();

        //Retrieve item Data (json format)
        $url_data = 'https://www.arcgis.com/sharing/rest/content/items/'.$itemId.'/data?f=json&token='.$access_token;
        $itemData = $this->get_json($url_data);

        return $itemData;
    }

    public function getItemInfo($itemId)
    {
        $access_token = $this->getToken();

        //Retrieve item Data (json format)
        $url_info = 'https://www.arcgis.com/sharing/rest/content/items/'.$itemId.'?f=json&token='.$access_token;
        $itemInfo = $this->get_json($url_info);

        return $itemInfo;
    }

    private function get_json ($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return $response = curl_exec($ch);
    }
}