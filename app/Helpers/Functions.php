<?php
namespace App\Helpers;

class Functions
{
    /**
     * Performs a CURL request accordingly to parameters
     * @param  <string> the url to request from
     * @param  <array>  data to sent (note: will perform a POST request automatically)
     * @return <string> with answer result or <false> on failure
    */
    public static function curlCall($url = null, $postData = [])
    {
        if(!$url){
            return false;
        }
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if(count($postData) > 0){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        $answer = curl_exec($ch);
        if(curl_errno($ch)){
            return false;
        }
        return $answer;
    }
}