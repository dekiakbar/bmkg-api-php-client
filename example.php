<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dekiakbar\BmkgApiPhpClient\Forecast;
use Dekiakbar\BmkgApiPhpClient\Earthquake;

// $data = new Forecast();

//this will retun available area code, you can pass this area code to execute method
//this will return array
// print_r($data->getAreaList());

//this will return data only from West java
// print_r($data->execute('JawaBarat')->getData());

//this will return data from all province
// print_r($data->execute()->getData());

//this will return available city list from West java province
// print_r($data->execute('JawaBarat')->getCityList()->getData());

//this will return data only for spesific city
// print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getData());

//this will return data for all city, coz there is no parameter passed to the function
// print_r($data->execute('JawaBarat')->getDataByCityId()->getData());

//this will return available data id from specific city
// print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getDataList()->getData());

//this will return specific data from specific city
// print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getDataById('hu')->getData());


// Earthquake
// $data = new Earthquake();

// This will return available code list for execute method
// print_r( $data->getCodeList() );

// This will method will get data from bmkg, then will fetch the data and return as StdClass onject
// if there is no parameter passed to the excute method then it will return defsult data (autogempa)
// print_r( $data->execute()->getData() );

// With parameter example
// print_r( $data->execute('lasttsunami')->getData() );