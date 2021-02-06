<?php

namespace Dekiakbar\BmkgApiPhpClient;

class Earthquake
{
    const BASE_URL = 'https://data.bmkg.go.id/';
    const PREFIX_URL = [
        'autogempa'       => 'autogempa.xml',
        'gempaterkini'    => 'gempaterkini.xml',
        'gempadirasakan'  => 'gempadirasakan.xml',
        'lasttsunami'     => 'lasttsunami.xml',
        'en_autogempa'    => 'en_autogempa.xml',
        'en_gempaterkini' => 'en_gempaterkini.xml',
    ];

    public $data;

    public function execute($code = null)
    {
        if ($code != null) {
            if (array_key_exists($code, self::PREFIX_URL)) {
                try {
                    $xmlContents = file_get_contents(self::BASE_URL.self::PREFIX_URL[$code]);
                    $this->data = simplexml_load_string($xmlContents, null, true);

                    return $this->objectBuilder();
                } catch (\Exception $e) {
                    echo 'Caught exception: '.$e->getMessage()."\n";
                }
            } else {
                throw new \Exception('Area code is wrong');
            }
        } else {
            try {
                $xmlContents = file_get_contents(self::BASE_URL.self::PREFIX_URL['autogempa']);
                $this->data = simplexml_load_string($xmlContents, null, true);

                return $this->objectBuilder();
            } catch (\Exception $e) {
                echo 'Caught exception: '.$e->getMessage()."\n";
            }
        }
    }

    public function objectBuilder()
    {
        $this->data = json_decode(json_encode($this->data));

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCodeList()
    {
        $this->data = array_keys(self::PREFIX_URL);

        return $this->data;
    }
}
