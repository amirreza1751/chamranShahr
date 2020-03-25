<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\StudyField;

class StudyFieldApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_study_field()
    {
        $studyField = factory(StudyField::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/study_fields', $studyField
        );

        $this->assertApiResponse($studyField);
    }

    /**
     * @test
     */
    public function test_read_study_field()
    {
        $studyField = factory(StudyField::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/study_fields/'.$studyField->id
        );

        $this->assertApiResponse($studyField->toArray());
    }

    /**
     * @test
     */
    public function test_update_study_field()
    {
        $studyField = factory(StudyField::class)->create();
        $editedStudyField = factory(StudyField::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/study_fields/'.$studyField->id,
            $editedStudyField
        );

        $this->assertApiResponse($editedStudyField);
    }

    /**
     * @test
     */
    public function test_delete_study_field()
    {
        $studyField = factory(StudyField::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/study_fields/'.$studyField->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/study_fields/'.$studyField->id
        );

        $this->response->assertStatus(404);
    }
}
