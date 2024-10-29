<?php

if( !class_exists( 'WP_Http' ) )
    include_once( ABSPATH . WPINC. '/class-http.php' );

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($url, $data = false, $api_key)
{
    $request = new WP_Http;

    $data["apikey"] = $api_key;
    $url = sprintf("%s?%s", $url, http_build_query($data));

    $result = $request->request($url);

    return $result['body'];
}

?>