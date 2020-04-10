<?php

namespace Dekiakbar\BmkgApiPhpClient;

class Earthquake
{
    const BASE_URL = "https://data.bmkg.go.id/";
    const PREFIX_URL = array(
        "autogempa" => "autogempa.xml",
        "gempaterkini" => "gempaterkini.xml",
        "gempadirasakan" => "gempadirasakan.xml",
        "lasttsunami" => "lasttsunami.xml",
        "eqmap" => "eqmap.gif",
        "en_autogempa" => "en_autogempa.xml",
        "en_gempaterkini" => "en_gempaterkini.xml"
    );

    public $data;

    public function execute($code=null){
        if( $code != null){
            if( array_key_exists($code, SELF::PREFIX_URL) ){
                try{
                    $xmlContents= file_get_contents(SELF::BASE_URL.SELF::PREFIX_URL[$code]);
                    $this->data = simplexml_load_string($xmlContents, null, true);

                    return $this->objectBuilder();
                    
                }catch(\Exception $e){
                    echo 'Caught exception: '.$e->getMessage()."\n";
                }
            }else{
                throw new \Exception("Area code is wrong");
            }
        }else{
            try{
                $xmlContents= file_get_contents(SELF::BASE_URL.SELF::PREFIX_URL['autogempa']);
                $this->data = simplexml_load_string($xmlContents, null, true);

                return $this->objectBuilder();
                
            }catch(\Exception $e){
                echo 'Caught exception: '.$e->getMessage()."\n";
            }
        }
    }

    public function objectBuilder(){
        $this->data = json_decode( json_encode($this->data) );
        return $this;
    }

    public function getData(){
        return $this->data;
    }

    public function getCodeList(){
        $this->data = array_keys(SELF::PREFIX_URL);
        return $this->data;
    }
}