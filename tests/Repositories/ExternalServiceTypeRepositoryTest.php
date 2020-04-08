<?php namespace Tests\Repositories;

use App\Models\ExternalServiceType;
use App\Repositories\ExternalServiceTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ExternalServiceTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExternalServiceTypeRepository
     */
    protected $externalServiceTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->externalServiceTypeRepo = \App::make(ExternalServiceTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->make()->toArray();

        $createdExternalServiceType = $this->externalServiceTypeRepo->create($externalServiceType);

        $createdExternalServiceType = $createdExternalServiceType->toArray();
        $this->assertArrayHasKey('id', $createdExternalServiceType);
        $this->assertNotNull($createdExternalServiceType['id'], 'Created ExternalServiceType must have id specified');
        $this->assertNotNull(ExternalServiceType::find($createdExternalServiceType['id']), 'ExternalServiceType with given id must be in DB');
        $this->assertModelData($externalServiceType, $createdExternalServiceType);
    }

    /**
     * @test read
     */
    public function test_read_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();

        $dbExternalServiceType = $this->externalServiceTypeRepo->find($externalServiceType->id);

        $dbExternalServiceType = $dbExternalServiceType->toArray();
        $this->assertModelData($externalServiceType->toArray(), $dbExternalServiceType);
    }

    /**
     * @test update
     */
    public function test_update_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();
        $fakeExternalServiceType = factory(ExternalServiceType::class)->make()->toArray();

        $updatedExternalServiceType = $this->externalServiceTypeRepo->update($fakeExternalServiceType, $externalServiceType->id);

        $this->assertModelData($fakeExternalServiceType, $updatedExternalServiceType->toArray());
        $dbExternalServiceType = $this->externalServiceTypeRepo->find($externalServiceType->id);
        $this->assertModelData($fakeExternalServiceType, $dbExternalServiceType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_external_service_type()
    {
        $externalServiceType = factory(ExternalServiceType::class)->create();

        $resp = $this->externalServiceTypeRepo->delete($externalServiceType->id);

        $this->assertTrue($resp);
        $this->assertNull(ExternalServiceType::find($externalServiceType->id), 'ExternalServiceType should not exist in DB');
    }
}
