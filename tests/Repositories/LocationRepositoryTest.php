<?php namespace Tests\Repositories;

use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LocationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LocationRepository
     */
    protected $locationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->locationRepo = \App::make(LocationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_location()
    {
        $location = factory(Location::class)->make()->toArray();

        $createdLocation = $this->locationRepo->create($location);

        $createdLocation = $createdLocation->toArray();
        $this->assertArrayHasKey('id', $createdLocation);
        $this->assertNotNull($createdLocation['id'], 'Created Location must have id specified');
        $this->assertNotNull(Location::find($createdLocation['id']), 'Location with given id must be in DB');
        $this->assertModelData($location, $createdLocation);
    }

    /**
     * @test read
     */
    public function test_read_location()
    {
        $location = factory(Location::class)->create();

        $dbLocation = $this->locationRepo->find($location->id);

        $dbLocation = $dbLocation->toArray();
        $this->assertModelData($location->toArray(), $dbLocation);
    }

    /**
     * @test update
     */
    public function test_update_location()
    {
        $location = factory(Location::class)->create();
        $fakeLocation = factory(Location::class)->make()->toArray();

        $updatedLocation = $this->locationRepo->update($fakeLocation, $location->id);

        $this->assertModelData($fakeLocation, $updatedLocation->toArray());
        $dbLocation = $this->locationRepo->find($location->id);
        $this->assertModelData($fakeLocation, $dbLocation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_location()
    {
        $location = factory(Location::class)->create();

        $resp = $this->locationRepo->delete($location->id);

        $this->assertTrue($resp);
        $this->assertNull(Location::find($location->id), 'Location should not exist in DB');
    }
}
