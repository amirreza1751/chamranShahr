<?php namespace Tests\Repositories;

use App\Models\StudyField;
use App\Repositories\StudyFieldRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StudyFieldRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StudyFieldRepository
     */
    protected $studyFieldRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->studyFieldRepo = \App::make(StudyFieldRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_study_field()
    {
        $studyField = factory(StudyField::class)->make()->toArray();

        $createdStudyField = $this->studyFieldRepo->create($studyField);

        $createdStudyField = $createdStudyField->toArray();
        $this->assertArrayHasKey('id', $createdStudyField);
        $this->assertNotNull($createdStudyField['id'], 'Created StudyField must have id specified');
        $this->assertNotNull(StudyField::find($createdStudyField['id']), 'StudyField with given id must be in DB');
        $this->assertModelData($studyField, $createdStudyField);
    }

    /**
     * @test read
     */
    public function test_read_study_field()
    {
        $studyField = factory(StudyField::class)->create();

        $dbStudyField = $this->studyFieldRepo->find($studyField->id);

        $dbStudyField = $dbStudyField->toArray();
        $this->assertModelData($studyField->toArray(), $dbStudyField);
    }

    /**
     * @test update
     */
    public function test_update_study_field()
    {
        $studyField = factory(StudyField::class)->create();
        $fakeStudyField = factory(StudyField::class)->make()->toArray();

        $updatedStudyField = $this->studyFieldRepo->update($fakeStudyField, $studyField->id);

        $this->assertModelData($fakeStudyField, $updatedStudyField->toArray());
        $dbStudyField = $this->studyFieldRepo->find($studyField->id);
        $this->assertModelData($fakeStudyField, $dbStudyField->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_study_field()
    {
        $studyField = factory(StudyField::class)->create();

        $resp = $this->studyFieldRepo->delete($studyField->id);

        $this->assertTrue($resp);
        $this->assertNull(StudyField::find($studyField->id), 'StudyField should not exist in DB');
    }
}
