<?php

namespace App\Models;

use DOMDocument;
use Carbon\Carbon;
use App\Helpers\Functions;

class News
{
    /**
     * Returns default respose array for RSS new api methods 
     * @return <array> [
     *             <bool>   success = false
     *             <string> error   = null
     *             <array>  content [
     *                 <int>   quantidade = 0
     *                 <array> noticia    = []
     *             ]           
     *         ]
    */
    public function getDefaultRSSResponse()
    {
        return [
            'success' => false,
            'error'   => null,
            'content' => [
                'quantidade' => 0,
                'noticias'   => []
            ]
        ];
    }

    /**
     * Perform a curl request to correio24horas.com.br to get 'rss' XML data
     * @return <string> xml from request or <false> on failure
    */
    public function getDataFromRss()
    {
        $url = 'https://www.correio24horas.com.br/rss/';
        $xmlDocument = Functions::curlCall($url);
        return ($xmlDocument ? $xmlDocument : false);
    }

    /**
     * Returns parsed data from correio24horas XML into an array containing NEWS data accordingly to parameters sent
     * @param  <string> the xml file
     * @param  <array> [
     *             <string> type  (date or category)
     *             <string> value
     *         ]
     * @return <array>  [
     *             <int>    'quantity' of returned news,
     *             <array>  'news'     with the news title
     *         ]
    */
    public function extractRssXMLData($xml, $filter)
    {
        if(!$xml || !is_array($filter) || !array_key_exists('type', $filter) || !array_key_exists('value', $filter)){
            return false;
        }
        $dateObj = Carbon::today();
        $filterByCategory = false;
        switch($filter['type']){
            case 'date':
                $dateObj = ($filter['value'] ? Carbon::parse($filter['value']) : Carbon::now());
            break;
            case 'category':
                $filterByCategory = $filter['value'];
            break;
            default:
                $dateObj = Carbon::now();
            break;
        }
        $itemsCount   = 0;
        $itemsArray   = [];
        $doc = new DOMDocument();
        $doc->loadXML($xml);
        $items = $doc->getElementsByTagName('item');
        foreach($items as $item){
            $title = trim($item->getElementsByTagName('title')[0]->nodeValue);
            if($filterByCategory){
                // filters by category
                $category = $item->getElementsByTagName('category')[0]->nodeValue;
                if($filterByCategory == 'allCategories'){
                    // gets all categories
                    if(!in_array($category, $itemsArray)){
                        $itemsArray[] = $category;
                        $itemsCount++;
                    }
                    continue;
                }
                if($category != $filterByCategory)
                    continue;
                if(!in_array($title, $itemsArray)){
                    $itemsArray[] = $title;
                    $itemsCount++;
                }
            }else{
                // filters by date
                $pubDate = $item->getElementsByTagName('pubDate')[0]->nodeValue;
                $pubDateObj = new Carbon($pubDate);
                if($pubDateObj->diffInDays($dateObj) == 0){
                    $itemsArray[] = $title;
                    $itemsCount++;
                }
            }
        }
        return [
            'quantity' => $itemsCount,
            'news'     => $itemsArray,
        ];
    }
}