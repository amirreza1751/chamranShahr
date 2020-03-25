<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Faculty;

class FacultyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_faculty()
    {
        $faculty = factory(Faculty::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/faculties', $faculty
        );

        $this->assertApiResponse($faculty);
    }

    /**
     * @test
     */
    public function test_read_faculty()
    {
        $faculty = factory(Faculty::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/faculties/'.$faculty->id
        );

        $this->assertApiResponse($faculty->toArray());
    }

    /**
     * @test
     */
    public function test_update_faculty()
    {
        $faculty = factory(Faculty::class)->create();
        $editedFaculty = factory(Faculty::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/faculties/'.$faculty->id,
            $editedFaculty
        );

        $this->assertApiResponse($editedFaculty);
    }

    /**
     * @test
     */
    public function test_delete_faculty()
    {
        $faculty = factory(Faculty::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/faculties/'.$faculty->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/faculties/'.$faculty->id
        );

        $this->response->assertStatus(404);
    }
}
