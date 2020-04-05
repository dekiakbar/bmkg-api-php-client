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

    const WEATHER_CODE_MAPPINGS = array(
        "en_us" => array(
            0 => "Clear Skies",
            100 => "Clear Skies",
            1 => "Partly Cloudy",
            101 => "Partly Cloudy",
            2 => "Partly Cloudy",
            102 => "Partly Cloudy",
            3 => "Mostly Cloudy",
            103 => "Mostly Cloudy",
            4 => "Overcast",
            104 => "Overcast",
            5 => "Haze",
            10 => "Smoke",
            45 => "Fog",
            60 => "Light Rain",
            61 => "Rain",
            63 => "Heavy Rain",
            80 => "Isolated Shower",
            95 => "Severe Thunderstorm",
            97 => "Severe Thunderstorm"
        ),
        'id_id' => array(
            0 => "Cerah",
            100 => "Cerah",
            1 => "Cerah Berawan",
            101 => "Cerah Berawan",
            2 => "Cerah Berawan",
            102 => "Cerah Berawan",
            3 => "Berawan",
            103 => "Berawan",
            4 => "Berawan Tebal",
            104 => "Berawan Tebal",
            5 => "Udara Kabur",
            10 => "Asap",
            45 => "Kabut",
            60 => "Hujan Ringan",
            61 => "Hujan Sedang",
            63 => "Hujan Lebat",
            80 => "Hujan Lokal",
            95 => "Hujan Petir",
            97 => "Hujan Petir"
        )
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
        $this->data->forecast->domain = $this->data->forecast->{'@attributes'}->domain;
        unset($this->data->forecast->{'@attributes'});
        unset($this->data->{'@attributes'});

        foreach( $this->data->forecast->area as $area ){
            $area->id = $area->{'@attributes'}->id;
            $area->latitude = $area->{'@attributes'}->latitude;
            $area->longitude  = $area->{'@attributes'}->longitude;
            $area->coordinate = $area->{'@attributes'}->coordinate;
            $area->type = $area->{'@attributes'}->type;
            $area->region = $area->{'@attributes'}->region;
            $area->level  = $area->{'@attributes'}->level;
            $area->descriptio = $area->{'@attributes'}->description;
            $area->domain = $area->{'@attributes'}->domain;
            $area->tags = $area->{'@attributes'}->tags;
            $area->name = (object)array('en_us' => $area->name[0],'id_id' => $area->name[1]);
            unset( $area->{'@attributes'} );

            if( property_exists($area, 'parameter') ){
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

                        if( $param->id == 't' || $param->id == 'tmin' || $param->id == 'tmax'){
                            $timerange->value = (object)array('c' => $timerange->value[0],'f' => $timerange->value[1]);
                        }elseif( $param->id == 'wd' ){
                            $timerange->value = (object)array(
                                'deg' => $timerange->value[0],
                                'card' => $timerange->value[1],
                                'sexa' => $timerange->value[2]
                            );
                        }elseif( $param->id == 'weather' ){
                            $timerange->description = (object)array(
                                'en_us' => SELF::WEATHER_CODE_MAPPINGS['en_us'][$timerange->value],
                                'id_id' => SELF::WEATHER_CODE_MAPPINGS['id_id'][$timerange->value],
                            );
                        }elseif( $param->id == 'ws' ){
                            $timerange->value = (object)array(
                                'knot' => $timerange->value[0],
                                'mph' => $timerange->value[1],
                                'kph' => $timerange->value[2],
                                'ms' => $timerange->value[3],
                            );
                        }
                    }
                }
            }
        }
        return $this;
    }

    public function getCityList($lang=null){
        $this->data = array_map(function($data) use($lang){
            if(is_object($data)){
                if( strtolower($lang) == 'en_us'){
                    $data->name->name = $data->name->en_us;
                    unset($data->name->en_us);
                    unset($data->name->id_id);
                    unset( $data->parameter );
                    return $data;
                }elseif(strtolower($lang) == 'id_id'){
                    $data->name->name = $data->name->id_id;
                    unset($data->name->en_us);
                    unset($data->name->id_id);
                    unset( $data->parameter );
                    return $data;
                }else{
                    unset( $data->parameter );
                    return $data;
                }
            }else{
                throw new \Exception("The data is not Object");
            }
            
        }, $this->data->forecast->area);
        return $this;
    }

    public function getDataByCityId($id=null){
        if( property_exists($this->data,'forecast') && property_exists($this->data->forecast,'area') ){
            if( !empty($id) || !is_null($id)){
                $this->data = array_values(
                    array_filter( 
                        array_map(function($data) use($id){
                            if( $data->id == $id ){
                                return $data;
                            }
                        }, $this->data->forecast->area) 
                    ) 
                )[0];
            }
        }else{
            return $this;
        }
        return $this;
    }

    public function getDataList(){
        $this->data = array_map(function($data){
            if( property_exists($data,'id') ){
                unset( $data->timerange );
                return $data;
            }
        },$this->data->parameter);
        return $this;
    }

    public function getDataById($id=null){
        $this->data =array_filter(
            array_map(function($data) use($id){
                if( $data->id == $id ){
                    return $data;
                }elseif( empty($id) || is_null($id) ){
                    throw new \Exception("Data id can not be null");
                }
            },$this->data->parameter)
        );
        $this->data = array_values( $this->data );
        if( count($this->data) > 0 ){
           $this->data = $this->data[0];
        }else{
            throw new \Exception("Can not find data id :".$id);
        }
        return $this;
    }

    public function getData(){
        return $this->data;
    }
}