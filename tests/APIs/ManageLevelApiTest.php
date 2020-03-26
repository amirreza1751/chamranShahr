<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ManageLevel;

class ManageLevelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/manage_levels', $manageLevel
        );

        $this->assertApiResponse($manageLevel);
    }

    /**
     * @test
     */
    public function test_read_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/manage_levels/'.$manageLevel->id
        );

        $this->assertApiResponse($manageLevel->toArray());
    }

    /**
     * @test
     */
    public function test_update_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();
        $editedManageLevel = factory(ManageLevel::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/manage_levels/'.$manageLevel->id,
            $editedManageLevel
        );

        $this->assertApiResponse($editedManageLevel);
    }

    /**
     * @test
     */
    public function test_delete_manage_level()
    {
        $manageLevel = factory(ManageLevel::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/manage_levels/'.$manageLevel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/manage_levels/'.$manageLevel->id
        );

        $this->response->assertStatus(404);
    }
}
