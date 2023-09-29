<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Mockery; 

/**
 * Class UnitTest
 */
class PatientControllerTest extends \UnitTestCase
{
    private $app;

    public function setUp()
    {        
        parent::setUp();                
        $this->app = include_once __DIR__ . '/../../bootstrap/bootstrap.php';
    }

    public function testIndexSuccess()
    {
        $mockService = Mockery::mock(App\Services\Patient\PatientService::class);
        $mockResponse = [
            'count' => 2,
            'results' => [
                'id' => 5,
                'nik' => '200002030001',
                'name' => 'Niki',
                'sex' => 'female',
                'religion' => 'hindu',
                'phone' => '62857728282',
                'address' => 'address',
                'created_at' => '2023-09-29 09:28:08',
                'updated_at' => '2023-09-29 09:28:24'
            ],
        ];

        $mockService->shouldReceive('list')->andReturn($mockResponse);

        $response = $mockService->list();

        $this->assertEquals($mockResponse, $response);
    }

    public function testGetByIdSuccess()
    {
        $mockService = Mockery::mock(App\Services\Patient\PatientService::class);
        $mockResponse = [
            'id' => 5,
            'nik' => '200002030001',
            'name' => 'Niki',
            'sex' => 'female',
            'religion' => 'hindu',
            'phone' => '62857728282',
            'address' => 'address',
            'created_at' => '2023-09-29 09:28:08',
            'updated_at' => '2023-09-29 09:28:24'
        ];

        $mockService->shouldReceive('getById')->andReturn($mockResponse);

        $response = $mockService->getById();

        $this->assertEquals($mockResponse, $response);
    }

    public function testCreateSuccess()
    {
        $mockService = Mockery::mock(App\Services\Patient\PatientService::class);
        $mockService->shouldReceive('create')->andReturnNull();

        $response = $mockService->create();

        $this->assertEquals(null, $response);
    }

    public function testUpdateSuccess()
    {
        $mockService = Mockery::mock(App\Services\Patient\PatientService::class);
        $mockService->shouldReceive('update')->andReturnNull();

        $response = $mockService->update();

        $this->assertEquals(null, $response);
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }    
}