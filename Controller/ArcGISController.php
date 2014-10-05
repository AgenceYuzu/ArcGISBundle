<?php

namespace Yuzu\ArcGISBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArcGISController extends Controller
{
    //public function __construct( MapFetcherInterface $mapFetcher )
    //{
    //    $this->mapFetcher = $mapFetcher;
    //}

    public function simpleMapAction($mapId, $long, $lat, $zoom = null, $basemap = null, array $layers = null)
    {
        //Define default values
        if ($zoom == null)
            $zoom = 12;
        if ($basemap == null)
            $basemap = 'topo';

        //To the view
        return $this->render('YuzuArcGISBundle:ArcGIS:map.html.twig', array('mapId' => $mapId,
                                                                            'zoom' => $zoom,
                                                                            'basemap' => $basemap,
                                                                            'lat' => $lat,
                                                                            'long' => $long,
                                                                            'layers' => $layers));
    }

    public function ArcGisOnlineMapAction($mapId, $itemId, $template=null)
    {
        if ($template == null)
            $template = 'YuzuArcGISBundle:ArcGIS:arcgisonlinemap.html.twig';

        $access_token = $this->get('yuzu.arc_gis.map_fetcher')->getToken();

        //Retrieve item Data (json format)
        $itemInfo = $this->get('yuzu.arc_gis.map_fetcher')->getItemInfo($itemId);

        //Retrieve item Data (json format)
        $itemData = $this->get('yuzu.arc_gis.map_fetcher')->getItemData($itemId);

        //To the view
        return $this->render($template, array('mapId' => $mapId,
                                              'itemId' => $itemId,
                                              'token' => $access_token,
                                              'itemInfo' => $itemInfo,
                                              'itemData' => $itemData));
    }

    public function ArcGisOnlineMapInfoAction($itemId, $template=null)
    {
        if ($template == null)
            $template = 'YuzuArcGISBundle:ArcGIS:arcgisonlinemapinfo.html.twig';

        //Retrieve item Data (json format)
        $itemInfo = $this->get('yuzu.arc_gis.map_fetcher')->getItemInfo($itemId);

        //To the view
        return $this->render($template, array( 'itemInfo' => $itemInfo ));
    }

}
