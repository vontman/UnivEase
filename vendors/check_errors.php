<?php

require 'xml2array.php';

class check_errors {

    function geterrorsArray($request, $host, $path, $port = 80) {
        $http_request = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $http_request .= "Content-Length: " . strlen($request) . "\r\n";
        $http_request .= "User-Agent: AtD/0.1\r\n";
        $http_request .= "\r\n";
        $http_request .= $request;

        $response = '';
        if (false != ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) )) {
            fwrite($fs, $http_request);

            while (!feof($fs)) {
                $response .= fgets($fs);
            }
            fclose($fs);
            $response = explode("\r\n\r\n", $response, 2);
        }

        return $response;
    }

//
//for debugging:
    function get_errors($request) {
        $str = $this->geterrorsArray($request, "service.afterthedeadline.com", '/checkDocument');

        $xml2arr = new XML2Array();
        $arr = $xml2arr->createArray($str[1]);
        if (!empty($arr['results'])) {
            $xml_errors = $arr['results']['error'];

            foreach ($xml_errors as $key => $error) {
                if (is_string($key)) {

                    return $arr['results'];
                } else {
                    return $xml_errors;
                }
            }
        } else {
            return false;
        }
    }

}

?>
