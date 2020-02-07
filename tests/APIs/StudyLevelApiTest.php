<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\StudyLevel;

class StudyLevelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/study_levels', $studyLevel
        );

        $this->assertApiResponse($studyLevel);
    }

    /**
     * @test
     */
    public function test_read_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/study_levels/'.$studyLevel->id
        );

        $this->assertApiResponse($studyLevel->toArray());
    }

    /**
     * @test
     */
    public function test_update_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();
        $editedStudyLevel = factory(StudyLevel::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/study_levels/'.$studyLevel->id,
            $editedStudyLevel
        );

        $this->assertApiResponse($editedStudyLevel);
    }

    /**
     * @test
     */
    public function test_delete_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/study_levels/'.$studyLevel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/study_levels/'.$studyLevel->id
        );

        $this->response->assertStatus(404);
    }
}
