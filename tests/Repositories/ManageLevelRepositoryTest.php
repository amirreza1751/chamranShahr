<?php namespace Tests\Repositories;

use App\Models\ManageLevel;
use App\Repositories\ManageLevelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ManageLevelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManageLevelRepository
     */
    protected $manageLevelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->manageLevelRepo = \App::make(ManageLevelRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->make()->toArray();

        $createdManageLevel = $this->manageLevelRepo->create($manageLevel);

        $createdManageLevel = $createdManageLevel->toArray();
        $this->assertArrayHasKey('id', $createdManageLevel);
        $this->assertNotNull($createdManageLevel['id'], 'Created ManageLevel must have id specified');
        $this->assertNotNull(ManageLevel::find($createdManageLevel['id']), 'ManageLevel with given id must be in DB');
        $this->assertModelData($manageLevel, $createdManageLevel);
    }

    /**
     * @test read
     */
    public function test_read_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();

        $dbManageLevel = $this->manageLevelRepo->find($manageLevel->id);

        $dbManageLevel = $dbManageLevel->toArray();
        $this->assertModelData($manageLevel->toArray(), $dbManageLevel);
    }

    /**
     * @test update
     */
    public function test_update_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();
        $fakeManageLevel = factory(ManageLevel::class)->make()->toArray();

        $updatedManageLevel = $this->manageLevelRepo->update($fakeManageLevel, $manageLevel->id);

        $this->assertModelData($fakeManageLevel, $updatedManageLevel->toArray());
        $dbManageLevel = $this->manageLevelRepo->find($manageLevel->id);
        $this->assertModelData($fakeManageLevel, $dbManageLevel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();

        $resp = $this->manageLevelRepo->delete($manageLevel->id);

        $this->assertTrue($resp);
        $this->assertNull(ManageLevel::find($manageLevel->id), 'ManageLevel should not exist in DB');
    }
}
