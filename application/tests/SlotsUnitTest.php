<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 2019-10-25
 * Time: 00:13
 */

use PHPUnit\Framework\TestCase;
require_once('APIDeclaration.php');

class SlotsUnitTest extends APIDeclaration
{
    public function testGetAllVenueJSON(){
        $this->action = 'showAllSlots';
        $APIurl = $this->APIurl . $this->action;
        $response = file_get_contents($APIurl);
        $this->assertIsString($response);
        return $response;
    }

    /**
     * @depends testGetAllVenueJSON
     */
    public function testVenuesJSONDecode($response){
        $this->assertJSON($response);
        $result = json_decode($response, true);
        $this->assertIsArray($result);
        return $result;
    }

    /**
     * @depends testVenuesJSONDecode
     */
    public function testJSONCustomFormats(array $result){
        $this->assertArrayHasKey('results', $result);
        $this->assertTrue($this->arrayIsAssociative($result));
        $this->assertIsArray($result['results']);
        $this->assertTrue($this->arrayIsSequential($result['results']));
        return $result['results'];
    }

    /**
     * @depends testJSONCustomFormats
     */
    public function testDatasetFields(array $datasets){
        foreach($datasets as $data){
            $this->assertIsArray($data);
            $this->assertTrue($this->arrayIsAssociative($data));
            $this->assertArrayHasKey('slot_id', $data);
            $this->assertArrayHasKey('venue_id', $data);
            $this->assertArrayHasKey('slot_date', $data);
            $this->assertArrayHasKey('slot_start_time', $data);
            $this->assertArrayHasKey('slot_end_time', $data);
            $this->assertArrayHasKey('slot_status', $data);
            $this->assertArrayHasKey('venue_name', $data);
            $this->assertArrayHasKey('venue_capacity', $data);
            $this->assertArrayHasKey('venue_location', $data);
        }
    }

    public function arrayIsAssociative($arr){
        if(array_keys($arr) !== range(0, count($arr) - 1))
            return true;
        else
            return false;
    }

    public function arrayIsSequential($arr){
        if(array_keys($arr) == range(0, count($arr) - 1))
            return true;
        else
            return false;
    }
}
