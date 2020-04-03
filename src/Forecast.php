<?php

namespace Dekiakbar\BmkgApiPhpClient;

class Forecast
{
    const BASE_URL = "https://data.bmkg.go.id/datamkg/MEWS/DigitalForecast/";
    const PREFIX_URL = array(
        'Aceh' => 'DigitalForecast-Aceh.xml',
        'Bali' => 'DigitalForecast-Bali.xml',
        'BangkaBelitung' => 'DigitalForecast-BangkaBelitung.xml',
        'Banten' => 'DigitalForecast-Banten.xml',
        'Bengkulu' => 'DigitalForecast-Bengkulu.xml',
        'DIYogyakarta' => 'DigitalForecast-DIYogyakarta.xml',
        'DKIJakarta' => 'DigitalForecast-DKIJakarta.xml',
        'Gorontalo' => 'DigitalForecast-Gorontalo.xml',
        'Jambi' => 'DigitalForecast-Jambi.xml',
        'JawaBarat' => 'DigitalForecast-JawaBarat.xml',
        'JawaTengah' => 'DigitalForecast-JawaTengah.xml',
        'JawaTimur' => 'DigitalForecast-JawaTimur.xml',
        'KalimantanBarat' => 'DigitalForecast-KalimantanBarat.xml',
        'KalimantanSelatan' => 'DigitalForecast-KalimantanSelatan.xml',
        'KalimantanTengah' => 'DigitalForecast-KalimantanTengah.xml',
        'KalimantanTimur' => 'DigitalForecast-KalimantanTimur.xml',
        'KalimantanUtara' => 'DigitalForecast-KalimantanUtara.xml',
        'KepulauanRiau' => 'DigitalForecast-KepulauanRiau.xml',
        'Lampung' => 'DigitalForecast-Lampung.xml',
        'Maluku' => 'DigitalForecast-Maluku.xml',
        'MalukuUtara' => 'DigitalForecast-MalukuUtara.xml',
        'NusaTenggaraBarat' => 'DigitalForecast-NusaTenggaraBarat.xml',
        'NusaTenggaraTimur' => 'DigitalForecast-NusaTenggaraTimur.xml',
        'Papua' => 'DigitalForecast-Papua.xml',
        'PapuaBarat' => 'DigitalForecast-PapuaBarat.xml',
        'Riau' => 'DigitalForecast-Riau.xml',
        'SulawesiBarat' => 'DigitalForecast-SulawesiBarat.xml',
        'SulawesiSelatan' => 'DigitalForecast-SulawesiSelatan.xml',
        'SulawesiTengah' => 'DigitalForecast-SulawesiTengah.xml',
        'SulawesiTenggara' => 'DigitalForecast-SulawesiTenggara.xml',
        'SulawesiUtara' => 'DigitalForecast-SulawesiUtara.xml',
        'SumateraBarat' => 'DigitalForecast-SumateraBarat.xml',
        'SumateraSelatan' => 'DigitalForecast-SumateraSelatan.xml',
        'SumateraUtara' => 'DigitalForecast-SumateraUtara.xml',
        'Indonesia' => 'DigitalForecast-Indonesia.xml'
    );

    public $data;

    public function execute($area=null){
        if( $area != null){
            if( array_key_exists($area, SELF::PREFIX_URL) ){
                try{
                    $xmlContents= file_get_contents(SELF::BASE_URL.SELF::PREFIX_URL[$area]);
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
                $xmlContents= file_get_contents(SELF::BASE_URL.SELF::PREFIX_URL['Indonesia']);
                $this->data = simplexml_load_string($xmlContents, null, true);

                return $this->objectBuilder();
                
            }catch(\Exception $e){
                echo 'Caught exception: '.$e->getMessage()."\n";
            }
        }
    }

    public function objectBuilder(){
        $this->data = json_decode( json_encode($this->data) );
        $this->data->source = $this->data->{'@attributes'}->source;
        $this->data->productioncenter = $this->data->{'@attributes'}->productioncenter;
        unset($this->data->{'@attributes'});

        foreach( $this->data->forecast->area as $area ){
            $area->id = $area->{'@attributes'}->id;
            $area->latitu = $area->{'@attributes'}->latitude;
            $area->longitude  = $area->{'@attributes'}->longitude;
            $area->coordinate = $area->{'@attributes'}->coordinate;
            $area->ty = $area->{'@attributes'}->type;
            $area->region = $area->{'@attributes'}->region;
            $area->level  = $area->{'@attributes'}->level;
            $area->descriptio = $area->{'@attributes'}->description;
            $area->domain = $area->{'@attributes'}->domain;
            $area->tags = $area->{'@attributes'}->tags;
            unset( $area->{'@attributes'} );

            foreach( $area->parameter as $param ){
                $param->id = $param->{'@attributes'}->id;
                $param->description = $param->{'@attributes'}->description;
                $param->type = $param->{'@attributes'}->type;

                unset($param->{'@attributes'});

                foreach( $param->timerange as $timerange ){
                    
                    if( $timerange->{'@attributes'}->type == 'hourly' ){
                        $timerange->type = $timerange->{'@attributes'}->type;
                        $timerange->h = $timerange->{'@attributes'}->h;
                        $timerange->datetime = $timerange->{'@attributes'}->datetime;

                        unset( $timerange->{'@attributes'} );
                    }elseif( $timerange->{'@attributes'}->type == 'daily' ){
                        $timerange->type = $timerange->{'@attributes'}->type;
                        $timerange->day = $timerange->{'@attributes'}->day;
                        $timerange->datetime = $timerange->{'@attributes'}->datetime;

                        unset( $timerange->{'@attributes'} );
                    }
                }
            }
        }
        return $this;
    }
}