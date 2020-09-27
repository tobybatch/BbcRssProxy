<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{

    # Home Page
    public function index(Request $request, Response $response)
    {
        $url = $_ENV["RSS_SRC"];
        $max_age = $_ENV['MAX_AGE_HOURS'];
        $cutoff_date = strtotime($max_age . ' hours ago', time());
        $str = file_get_contents($url);

        $xml = new DOMDocument();//new xml DOMDocument
        $xml->formatOutput = true;
        $xml->preserveWhiteSpace = false;
        $xml->loadXML($str) or die("Error");

        $items = $xml->getElementsByTagName("item");
        foreach ($items as $item) {
            $date_node = $item->getElementsByTagName("pubDate")->item(0);
            $date = $date_node->nodeValue;
            if (strtotime($date) < $cutoff_date) {
                $date_node->parentNode->removeChild($date_node);
            }
        }

        $response->headers->set('Content-Type', "text/xml");
        $response->setContent($xml->saveXML());
        return $response;
    }
}
