# BMKG API PHP Client

<p align="center">
    <a href="https://travis-ci.com/github/dekiakbar/bmkg-api-php-client"><img src="https://travis-ci.com/dekiakbar/bmkg-api-php-client.svg?branch=master"></a>
    <a href="https://packagist.org/packages/dekiakbar/bmkg-api-php-client"><img src="https://poser.pugx.org/dekiakbar/bmkg-api-php-client/v"></a>
    <a href="https://github.com/dekiakbar/bmkg-api-php-client/blob/master/LICENSE"><img src="https://poser.pugx.org/dekiakbar/bmkg-api-php-client/license"></a>
</p>

> This Project is used for scrapping data from https://data.bmkg.go.id/

## Warning
### **It is mandatory to list BMKG (Meteorology, Climatology and Geophysics Agency) as data sources and display them on your application or system.**
***

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Before you install this package, make sure that the requirements below are met

```
PHP >= 5.6
php-xml 
```

### Installing

To install this package, please follow the below instruction

Install via composer using below command

```
composer require dekiakbar/bmkg-api-php-client
```
And you're done, enjoy it :)

### Example Usage

#### Forecast
* Get all forecast data by province, this method will return all city data including Temperature,Humidity,Wind Speed,Wind Direction and Weather, this method will return data type : **stdclass object**, if you did not passing any parameter to **execute()** method then it will return data for all province.  
```php
require_once __DIR__ . '/vendor/autoload.php';
use Dekiakbar\BmkgApiPhpClient\Forecast;
$data = new Forecast();
//this will return data only from  West java province
print_r($data->execute('JawaBarat')->getData());
//this will return data from all provinces
print_r($data->execute()->getData());
```

* Get available area code
```php
//this will retun available area code, you can pass this area code to execute method
//this will return array
print_r($data->getAreaList());
```

* Get city list
```php
//this will return available city list from West java province
print_r($data->execute('JawaBarat')->getCityList()->getData());
```

* Get data for specific city
```php
//this will return data only for spesific city
print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getData());
//this will return data for all city, coz there is no parameter passed to the function
print_r($data->execute('JawaBarat')->getDataByCityId()->getData());
```

* Get data list
```php
//this will return available data id from specific city
print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getDataList()->getData());
```

* Get specific data by Id, the data id can not be null, use **getDataList()** to get available data id.
```php
//this will return specific data from specific city
print_r($data->execute('JawaBarat')->getDataByCityId('501212')->getDataById('hu')->getData());
```

#### Earthquake 
* Get earthquake data from bmkg open data, this method will return data type : **stdclass object**, if you did not passing any parameter to **execute()** method then it will return data as same as **autogempa** code.
```php
require_once __DIR__ . '/vendor/autoload.php';
use Dekiakbar\BmkgApiPhpClient\Earthquake;

// Earthquake class initialization
$data = new Earthquake();

// This will method will get data from bmkg, then will fetch the data and return as StdClass onject
// if there is no parameter passed to the excute method then it will return defsult data (autogempa)
print_r( $data->execute()->getData() );

// With parameter example
print_r( $data->execute('lasttsunami')->getData() );
```

* Get available code list
```php
// This will return available code list for execute method
print_r( $data->getCodeList() );
```

## Built With

* [PHP](https://www.php.net/) - The web scripting language used
* [Packagist](https://packagist.org/) - Composer package repository
* [BMKG](https://data.bmkg.go.id/) - Used as data source

## Contributing

Please fork this repository, and create new pull request if you want to contribute on this project.or open a new issue if you find something wrong with this project.

## Authors

* [**Deki Akbar**](https://github.com/dekiakbar) - *Initial work*

See also the list of [contributors](https://github.com/dekiakbar/bmkg-api-php-client/graphs/contributors) who participated in this project.

## License

<a href="https://github.com/dekiakbar/bmkg-api-php-client/blob/master/LICENSE"><img src="https://poser.pugx.org/dekiakbar/bmkg-api-php-client/license"></a>
