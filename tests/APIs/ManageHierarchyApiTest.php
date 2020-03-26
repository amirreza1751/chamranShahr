<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ManageHierarchy;

class ManageHierarchyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/manage_hierarchies', $manageHierarchy
        );

        $this->assertApiResponse($manageHierarchy);
    }

    /**
     * @test
     */
    public function test_read_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/manage_hierarchies/'.$manageHierarchy->id
        );

        $this->assertApiResponse($manageHierarchy->toArray());
    }

    /**
     * @test
     */
    public function test_update_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();
        $editedManageHierarchy = factory(ManageHierarchy::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/manage_hierarchies/'.$manageHierarchy->id,
            $editedManageHierarchy
        );

        $this->assertApiResponse($editedManageHierarchy);
    }

    /**
     * @test
     */
    public function test_delete_manage_hierarchy()
    {
        $manageHierarchy = factory(ManageHierarchy::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/manage_hierarchies/'.$manageHierarchy->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/manage_hierarchies/'.$manageHierarchy->id
        );

        $this->response->assertStatus(404);
    }
}
