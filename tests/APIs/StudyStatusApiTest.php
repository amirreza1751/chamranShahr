<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\StudyStatus;

class StudyStatusApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/study_statuses', $studyStatus
        );

        $this->assertApiResponse($studyStatus);
    }

    /**
     * @test
     */
    public function test_read_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/study_statuses/'.$studyStatus->id
        );

        $this->assertApiResponse($studyStatus->toArray());
    }

    /**
     * @test
     */
    public function test_update_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();
        $editedStudyStatus = factory(StudyStatus::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/study_statuses/'.$studyStatus->id,
            $editedStudyStatus
        );

        $this->assertApiResponse($editedStudyStatus);
    }

    /**
     * @test
     */
    public function test_delete_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/study_statuses/'.$studyStatus->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/study_statuses/'.$studyStatus->id
        );

        $this->response->assertStatus(404);
    }
}
