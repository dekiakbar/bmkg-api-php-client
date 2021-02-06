<?php

namespace Dekiakbar\BmkgApiPhpClient\Tests;

use Dekiakbar\BmkgApiPhpClient\Earthquake;
use PHPUnit\Framework\TestCase;

class EarthquakeTest extends TestCase
{
    private $earthquake;

    protected function setUp(): void
    {
        $this->earthquake = new Earthquake();
    }

    protected function tearDown(): void
    {
        $this->earthquake = null;
    }

    public function testGetCodeList()
    {
        $datas = $this->earthquake->getCodeList();
        $this->assertIsArray($datas);
        foreach ($datas as $data) {
            $this->assertNotNull($data);
        }
    }

    public function testGetData()
    {
        $datas = $this->earthquake->execute()->getData();
        $this->assertIsObject($datas);
        $this->assertIsObject($datas->gempa);
        $this->assertNotNull($datas->gempa->Tanggal);
        $this->assertNotNull($datas->gempa->Jam);
        $this->assertNotNull($datas->gempa->point);
        $this->assertNotNull($datas->gempa->Lintang);
        $this->assertNotNull($datas->gempa->Bujur);
        $this->assertNotNull($datas->gempa->Magnitude);
        $this->assertNotNull($datas->gempa->Kedalaman);
        $this->assertNotNull($datas->gempa->_symbol);
        $this->assertNotNull($datas->gempa->Wilayah1);
        $this->assertNotNull($datas->gempa->Wilayah2);
        $this->assertNotNull($datas->gempa->Wilayah3);
        $this->assertNotNull($datas->gempa->Wilayah4);
        $this->assertNotNull($datas->gempa->Wilayah5);
        $this->assertNotNull($datas->gempa->Potensi);
    }

    public function testAllData()
    {
        $lists = $this->earthquake->getCodeList();
        foreach ($lists as $list) {
            $datas = $this->earthquake->execute($list);
            $this->assertIsObject($datas);
        }
    }
}
