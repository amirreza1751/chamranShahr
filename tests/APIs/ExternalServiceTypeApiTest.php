<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ExternalServiceType;

class ExternalServiceTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/external_service_types', $externalServiceType
        );

        $this->assertApiResponse($externalServiceType);
    }

    /**
     * @test
     */
    public function test_read_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/external_service_types/'.$externalServiceType->id
        );

        $this->assertApiResponse($externalServiceType->toArray());
    }

    /**
     * @test
     */
    public function test_update_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();
        $editedExternalServiceType = factory(ExternalServiceType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/external_service_types/'.$externalServiceType->id,
            $editedExternalServiceType
        );

        $this->assertApiResponse($editedExternalServiceType);
    }

    /**
     * @test
     */
    public function test_delete_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/external_service_types/'.$externalServiceType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/external_service_types/'.$externalServiceType->id
        );

        $this->response->assertStatus(404);
    }
}
