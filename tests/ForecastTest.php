<?php
namespace Dekiakbar\BmkgApiPhpClient\Tests;

use PHPUnit\Framework\TestCase;
use Dekiakbar\BmkgApiPhpClient\Forecast;

class ForecastTest extends TestCase 
{
    private $forecast;

    private $areaList = [
        'Aceh',
        'Bali',
        'BangkaBelitung',
        'Banten',
        'Bengkulu',
        'DIYogyakarta',
        'DKIJakarta',
        'Gorontalo',
        'Jambi',
        'JawaBarat',
        'JawaTengah',
        'JawaTimur',
        'KalimantanBarat',
        'KalimantanSelatan',
        'KalimantanTengah',
        'KalimantanTimur',
        'KalimantanUtara',
        'KepulauanRiau',
        'Lampung',
        'Maluku',
        'MalukuUtara',
        'NusaTenggaraBarat',
        'NusaTenggaraTimur',
        'Papua',
        'PapuaBarat',
        'Riau',
        'SulawesiBarat',
        'SulawesiSelatan',
        'SulawesiTengah',
        'SulawesiTenggara',
        'SulawesiUtara',
        'SumateraBarat',
        'SumateraSelatan',
        'SumateraUtara',
        'Indonesia'
    ];

    protected function setUp(): void
    {
        $this->forecast = new Forecast();
    }

    protected function tearDown(): void
    {
        $this->forecast = NULL;
    }

    public function testGetAreaList()
    {
        $data = $this->forecast->getAreaList();
        $this->assertIsArray($data);
        $this->assertCount(35, $data);
        foreach($data as $i => $d){
            $this->assertStringContainsString($this->areaList[$i], $data[$i]);
        }
    }

    public function testExecute()
    {
        $areas = ['Aceh','Bali','BangkaBelitung'];
        foreach( $areas as $areaList ){
            $data = $this->forecast->execute($areaList);
            $this->assertIsObject($data);
            $this->assertIsObject($data->data);
            $this->assertIsObject($data->data->forecast);
            $this->assertIsObject($data->data->forecast->issue);
            $this->assertIsArray($data->data->forecast->area);
            foreach($data->data->forecast->area as $area){
                $this->assertIsObject($area);
                $this->assertIsObject($area->name);
                $this->assertNotNull($area->id);
                $this->assertNotNull($area->latitude);
                $this->assertNotNull($area->longitude);
                $this->assertNotNull($area->coordinate);
                $this->assertNotNull($area->type);
                $this->assertNotNull($area->level);
                $this->assertNotNull($area->descriptio);
                $this->assertNotNull($area->domain);
                if( property_exists($area, 'parameter') ){
                    $this->assertIsArray($area->parameter);
                    foreach($area->parameter as $param){
                        $this->assertIsObject($param);
                        $this->assertIsArray($param->timerange);
                        foreach($param->timerange as $time){
                            $this->assertNotNull($time->value);
                            $this->assertNotNull($time->type);
                            $this->assertNotNull($time->datetime);
                        }
                    }
                }
            }
        }
    }

    public function testGetCityList()
    {
        $areas = ['SulawesiBarat','SulawesiSelatan','SulawesiTengah'];
        foreach( $areas as $areaList ){
            $datas = $this->forecast->execute($areaList)->getCityList()->getData();
            $this->assertIsArray($datas);
            foreach($datas as $data){
                $this->assertIsObject($data->name);
                $this->assertNotNull($data->id);
                $this->assertNotNull($data->latitude);
                $this->assertNotNull($data->longitude);
                $this->assertNotNull($data->coordinate);
                $this->assertNotNull($data->type);
                $this->assertNotNull($data->level);
                $this->assertNotNull($data->descriptio);
                $this->assertNotNull($data->domain);
            }
        }
    }

    public function testGetDataByCityId()
    {
        $areas = ['Lampung'];
        foreach( $areas as $areaList ){
            $datas = $this->forecast->execute($areaList)->getCityList()->getData();
            $this->assertIsArray($datas);
            foreach($datas as $data){
                $newDatas = $this->forecast->execute($areaList)->getDataByCityId($data->id)->getData();
                $this->assertIsObject($newDatas);
                $this->assertIsObject($newDatas->name);
                if( property_exists($newDatas, 'parameter') ){
                    $this->assertIsArray($newDatas->parameter);
                    foreach( $newDatas->parameter as $param ){
                        $this->assertIsObject($param);
                        foreach( $param->timerange as $time){
                            $this->assertNotNull($time->value);
                            $this->assertNotNull($time->type);
                            if( property_exists($time, 'h') ){
                                $this->assertNotNull($time->h);
                            }elseif( property_exists($time, 'day') ){
                                $this->assertNotNull($time->day);
                            }
                            
                            $this->assertNotNull($time->datetime);
                        }
                    }
                }
            }
        }
    }

    public function testGetDataList()
    {
        $datas = $this->forecast->execute('JawaBarat')->getDataByCityId('501212')->getDataList()->getData();
        $this->assertIsArray($datas);
        foreach($datas as $data){
            $this->assertNotNull($data->id);
            $this->assertNotNull($data->description);
            $this->assertNotNull($data->type);
        }
    }

    public function testGetDataById()
    {
        $datas = $this->forecast->execute('JawaBarat')->getDataByCityId('501212')->getDataById('hu')->getData();
        $this->assertIsObject($datas);
        $this->assertNotNull($datas->id);
        $this->assertNotNull($datas->timerange);
        $this->assertNotNull($datas->description);
        $this->assertNotNull($datas->type);
        foreach( $datas->timerange as $time ){
            $this->assertNotNull($time->value);
            $this->assertNotNull($time->type);
            $this->assertNotNull($time->h);
            $this->assertNotNull($time->datetime);
        }
    }
}