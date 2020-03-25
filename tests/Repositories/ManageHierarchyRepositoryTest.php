<?php namespace Tests\Repositories;

use App\Models\ManageHierarchy;
use App\Repositories\ManageHierarchyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ManageHierarchyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManageHierarchyRepository
     */
    protected $manageHierarchyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->manageHierarchyRepo = \App::make(ManageHierarchyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->make()->toArray();

        $createdManageHierarchy = $this->manageHierarchyRepo->create($manageHierarchy);

        $createdManageHierarchy = $createdManageHierarchy->toArray();
        $this->assertArrayHasKey('id', $createdManageHierarchy);
        $this->assertNotNull($createdManageHierarchy['id'], 'Created ManageHierarchy must have id specified');
        $this->assertNotNull(ManageHierarchy::find($createdManageHierarchy['id']), 'ManageHierarchy with given id must be in DB');
        $this->assertModelData($manageHierarchy, $createdManageHierarchy);
    }

    /**
     * @test read
     */
    public function test_read_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();

        $dbManageHierarchy = $this->manageHierarchyRepo->find($manageHierarchy->id);

        $dbManageHierarchy = $dbManageHierarchy->toArray();
        $this->assertModelData($manageHierarchy->toArray(), $dbManageHierarchy);
    }

    /**
     * @test update
     */
    public function test_update_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();
        $fakeManageHierarchy = factory(ManageHierarchy::class)->make()->toArray();

        $updatedManageHierarchy = $this->manageHierarchyRepo->update($fakeManageHierarchy, $manageHierarchy->id);

        $this->assertModelData($fakeManageHierarchy, $updatedManageHierarchy->toArray());
        $dbManageHierarchy = $this->manageHierarchyRepo->find($manageHierarchy->id);
        $this->assertModelData($fakeManageHierarchy, $dbManageHierarchy->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();

        $resp = $this->manageHierarchyRepo->delete($manageHierarchy->id);

        $this->assertTrue($resp);
        $this->assertNull(ManageHierarchy::find($manageHierarchy->id), 'ManageHierarchy should not exist in DB');
    }
}
