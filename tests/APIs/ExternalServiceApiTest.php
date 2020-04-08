<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ExternalService;

class ExternalServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_external_service()
    {
        $externalService = factory(ExternalService::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/external_services', $externalService
        );

        $this->assertApiResponse($externalService);
    }

    /**
     * @test
     */
    public function test_read_external_service()
    {
        $externalService = factory(ExternalService::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/external_services/'.$externalService->id
        );

        $this->assertApiResponse($externalService->toArray());
    }

    /**
     * @test
     */
    public function test_update_external_service()
    {
        $externalService = factory(ExternalService::class)->create();
        $editedExternalService = factory(ExternalService::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/external_services/'.$externalService->id,
            $editedExternalService
        );

        $this->assertApiResponse($editedExternalService);
    }

    /**
     * @test
     */
    public function test_delete_external_service()
    {
        $externalService = factory(ExternalService::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/external_services/'.$externalService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/external_services/'.$externalService->id
        );

        $this->response->assertStatus(404);
    }
}
