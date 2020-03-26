<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ManageHistory;

class ManageHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/manage_histories', $manageHistory
        );

        $this->assertApiResponse($manageHistory);
    }

    /**
     * @test
     */
    public function test_read_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/manage_histories/'.$manageHistory->id
        );

        $this->assertApiResponse($manageHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();
        $editedManageHistory = factory(ManageHistory::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/manage_histories/'.$manageHistory->id,
            $editedManageHistory
        );

        $this->assertApiResponse($editedManageHistory);
    }

    /**
     * @test
     */
    public function test_delete_manage_history()
    {
        $manageHistory = factory(ManageHistory::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/manage_histories/'.$manageHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/manage_histories/'.$manageHistory->id
        );

        $this->response->assertStatus(404);
    }
}
