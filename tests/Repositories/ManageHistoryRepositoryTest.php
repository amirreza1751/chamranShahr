<?php namespace Tests\Repositories;

use App\Models\ManageHistory;
use App\Repositories\ManageHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ManageHistoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManageHistoryRepository
     */
    protected $manageHistoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->manageHistoryRepo = \App::make(ManageHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->make()->toArray();

        $createdManageHistory = $this->manageHistoryRepo->create($manageHistory);

        $createdManageHistory = $createdManageHistory->toArray();
        $this->assertArrayHasKey('id', $createdManageHistory);
        $this->assertNotNull($createdManageHistory['id'], 'Created ManageHistory must have id specified');
        $this->assertNotNull(ManageHistory::find($createdManageHistory['id']), 'ManageHistory with given id must be in DB');
        $this->assertModelData($manageHistory, $createdManageHistory);
    }

    /**
     * @test read
     */
    public function test_read_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();

        $dbManageHistory = $this->manageHistoryRepo->find($manageHistory->id);

        $dbManageHistory = $dbManageHistory->toArray();
        $this->assertModelData($manageHistory->toArray(), $dbManageHistory);
    }

    /**
     * @test update
     */
    public function test_update_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();
        $fakeManageHistory = factory(ManageHistory::class)->make()->toArray();

        $updatedManageHistory = $this->manageHistoryRepo->update($fakeManageHistory, $manageHistory->id);

        $this->assertModelData($fakeManageHistory, $updatedManageHistory->toArray());
        $dbManageHistory = $this->manageHistoryRepo->find($manageHistory->id);
        $this->assertModelData($fakeManageHistory, $dbManageHistory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();

        $resp = $this->manageHistoryRepo->delete($manageHistory->id);

        $this->assertTrue($resp);
        $this->assertNull(ManageHistory::find($manageHistory->id), 'ManageHistory should not exist in DB');
    }
}
