<?php namespace Tests\Repositories;

use App\Models\AdType;
use App\Repositories\AdTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AdTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AdTypeRepository
     */
    protected $adTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->adTypeRepo = \App::make(AdTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_ad_type()
    {
        $adType = factory(AdType::class)->make()->toArray();

        $createdAdType = $this->adTypeRepo->create($adType);

        $createdAdType = $createdAdType->toArray();
        $this->assertArrayHasKey('id', $createdAdType);
        $this->assertNotNull($createdAdType['id'], 'Created AdType must have id specified');
        $this->assertNotNull(AdType::find($createdAdType['id']), 'AdType with given id must be in DB');
        $this->assertModelData($adType, $createdAdType);
    }

    /**
     * @test read
     */
    public function test_read_ad_type()
    {
        $adType = factory(AdType::class)->create();

        $dbAdType = $this->adTypeRepo->find($adType->id);

        $dbAdType = $dbAdType->toArray();
        $this->assertModelData($adType->toArray(), $dbAdType);
    }

    /**
     * @test update
     */
    public function test_update_ad_type()
    {
        $adType = factory(AdType::class)->create();
        $fakeAdType = factory(AdType::class)->make()->toArray();

        $updatedAdType = $this->adTypeRepo->update($fakeAdType, $adType->id);

        $this->assertModelData($fakeAdType, $updatedAdType->toArray());
        $dbAdType = $this->adTypeRepo->find($adType->id);
        $this->assertModelData($fakeAdType, $dbAdType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_ad_type()
    {
        $adType = factory(AdType::class)->create();

        $resp = $this->adTypeRepo->delete($adType->id);

        $this->assertTrue($resp);
        $this->assertNull(AdType::find($adType->id), 'AdType should not exist in DB');
    }
}
