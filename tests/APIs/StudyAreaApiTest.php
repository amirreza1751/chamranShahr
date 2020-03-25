<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\StudyArea;

class StudyAreaApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_study_area()
    {
        $studyArea = factory(StudyArea::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/study_areas', $studyArea
        );

        $this->assertApiResponse($studyArea);
    }

    /**
     * @test
     */
    public function test_read_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/study_areas/'.$studyArea->id
        );

        $this->assertApiResponse($studyArea->toArray());
    }

    /**
     * @test
     */
    public function test_update_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();
        $editedStudyArea = factory(StudyArea::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/study_areas/'.$studyArea->id,
            $editedStudyArea
        );

        $this->assertApiResponse($editedStudyArea);
    }

    /**
     * @test
     */
    public function test_delete_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/study_areas/'.$studyArea->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/study_areas/'.$studyArea->id
        );

        $this->response->assertStatus(404);
    }
}
