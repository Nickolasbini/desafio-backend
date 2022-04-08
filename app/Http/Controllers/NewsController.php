<?php

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;

class NewsController extends Controller 
{
    /**
     * Returns data from correio24horas XML into an array containing NEWS data filtered by DATE or by CATEGORY name
     * @param  <string> the category name to gather news from (default = null)
     * @return <json array> [
     *             <bool>   success
     *             <string> error
     *             <array>  content [
     *                 <int>   quantidade
     *                 <array> noticia
     *             ]           
     *         ]
    */
    public function getNews($category = null)
    {
        $newsObj = new News();
        $response = $newsObj->getDefaultRSSResponse();
        $xmlResult = $newsObj->getDataFromRss();
        if(!$xmlResult){
            $response['error'] = "retorno inválido do endereço remoto";
            return json_encode($response);
        }
        $parameterArray = [
            'type'  => 'date',
            'value' => null
        ];
        if($category){
            $parameterArray['type']  = 'category';
            $parameterArray['value'] =  $category;
        }
        $result = $newsObj->extractRssXMLData($xmlResult, $parameterArray);
        if(!$result){
            return json_encode($response);
        }
        $response['success'] = true;
        $response['content']['quantidade'] = $result['quantity'];
        $response['content']['noticias']   = $result['news'];
        return json_encode($response);
    }

    /**
     * Returns data from correio24horas XML into an array containing NEWS data filtered by CATEGORY
     * @param  <string> the category name
     * @return <json array> [
     *             <bool>   success
     *             <string> error
     *             <array>  content [
     *                 <int>   quantidade
     *                 <array> noticia
     *             ]           
     *         ]
    */
    public function getNewsCategories()
    {
        $newsObj = new News();
        $response = $newsObj->getDefaultRSSResponse();
        $xmlResult = $newsObj->getDataFromRss();
        if(!$xmlResult){
            $response['error'] = "retorno inválido do endereço remoto";
            return json_encode($response);
        }
        $parameterArray = [
            'type'  => 'category',
            'value' => 'allCategories'
        ];
        $result = $newsObj->extractRssXMLData($xmlResult, $parameterArray);
        if(!$result){
            return json_encode($response);
        }
        $response['success'] = true;
        $response['content']['quantidade'] = $result['quantity'];
        $response['content']['noticias']   = $result['news'];
        //$response['category'] = $categoryName;
        return json_encode($response);
    }
}

