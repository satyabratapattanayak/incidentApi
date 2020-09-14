<?php


use PHPUnit\Framework\TestCase;
use App\Modules\Incidents\Models\User;

class IncidentTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost'
        ]);
    }
    
    /**
     * Test cases for get Incidents api
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function test_get_incident()
    {
        $incidentGetResponse = $this->client->get('/api/incident', []);
        $this->assertEquals(200, $incidentGetResponse->getStatusCode());
        $incidentGetData = json_decode($incidentGetResponse->getBody(), true);
        $this->assertArrayHasKey('data', $incidentGetData);
        $this->assertArrayHasKey('status', $incidentGetData);
        $this->assertEquals(1, $incidentGetData['status']);
    }

    /**
     * Test cases for get categories api
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function test_category()
    {
        $categoryResponse = $this->client->get('/api/incident/categories', []);
        $this->assertEquals(200, $categoryResponse->getStatusCode());
        $categoryData = json_decode($categoryResponse->getBody(), true);
        $this->assertArrayHasKey('data', $categoryData);
        $this->assertArrayHasKey('status', $categoryData);
        $this->assertEquals(1, $categoryData['status']);
    }

    /**
     * Test cases for save Incidents api
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function test_save_incident()
    {
        $incidentSaveResponse = $this->client->post('/api/incident', [
            'data' => [
            'location'    => ["latitude"=>12.9231501,"longitude"=>74.7818517],
            'title'     => 'incident title'
            ]
        ]);
        $this->assertEquals(200, $incidentSaveResponse->getStatusCode());
        $incidentSaveData = json_decode($incidentSaveResponse->getBody(), true);

        // This Throws the error as the status from the method is 0
        $this->assertEquals(1, $incidentSaveData['status']);
    }
}
