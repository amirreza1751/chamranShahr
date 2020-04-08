<?php namespace Tests\Repositories;

use App\Models\ExternalService;
use App\Repositories\ExternalServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ExternalServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExternalServiceRepository
     */
    protected $externalServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->externalServiceRepo = \App::make(ExternalServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_external_service()
    {
        $externalService = factory(ExternalService::class)->make()->toArray();

        $createdExternalService = $this->externalServiceRepo->create($externalService);

        $createdExternalService = $createdExternalService->toArray();
        $this->assertArrayHasKey('id', $createdExternalService);
        $this->assertNotNull($createdExternalService['id'], 'Created ExternalService must have id specified');
        $this->assertNotNull(ExternalService::find($createdExternalService['id']), 'ExternalService with given id must be in DB');
        $this->assertModelData($externalService, $createdExternalService);
    }

    /**
     * @test read
     */
    public function test_read_external_service()
    {
        $externalService = factory(ExternalService::class)->create();

        $dbExternalService = $this->externalServiceRepo->find($externalService->id);

        $dbExternalService = $dbExternalService->toArray();
        $this->assertModelData($externalService->toArray(), $dbExternalService);
    }

    /**
     * @test update
     */
    public function test_update_external_service()
    {
        $externalService = factory(ExternalService::class)->create();
        $fakeExternalService = factory(ExternalService::class)->make()->toArray();

        $updatedExternalService = $this->externalServiceRepo->update($fakeExternalService, $externalService->id);

        $this->assertModelData($fakeExternalService, $updatedExternalService->toArray());
        $dbExternalService = $this->externalServiceRepo->find($externalService->id);
        $this->assertModelData($fakeExternalService, $dbExternalService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_external_service()
    {
        $externalService = factory(ExternalService::class)->create();

        $resp = $this->externalServiceRepo->delete($externalService->id);

        $this->assertTrue($resp);
        $this->assertNull(ExternalService::find($externalService->id), 'ExternalService should not exist in DB');
    }
}
