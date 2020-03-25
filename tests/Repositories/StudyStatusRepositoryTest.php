<?php namespace Tests\Repositories;

use App\Models\StudyStatus;
use App\Repositories\StudyStatusRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StudyStatusRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StudyStatusRepository
     */
    protected $studyStatusRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->studyStatusRepo = \App::make(StudyStatusRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->make()->toArray();

        $createdStudyStatus = $this->studyStatusRepo->create($studyStatus);

        $createdStudyStatus = $createdStudyStatus->toArray();
        $this->assertArrayHasKey('id', $createdStudyStatus);
        $this->assertNotNull($createdStudyStatus['id'], 'Created StudyStatus must have id specified');
        $this->assertNotNull(StudyStatus::find($createdStudyStatus['id']), 'StudyStatus with given id must be in DB');
        $this->assertModelData($studyStatus, $createdStudyStatus);
    }

    /**
     * @test read
     */
    public function test_read_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();

        $dbStudyStatus = $this->studyStatusRepo->find($studyStatus->id);

        $dbStudyStatus = $dbStudyStatus->toArray();
        $this->assertModelData($studyStatus->toArray(), $dbStudyStatus);
    }

    /**
     * @test update
     */
    public function test_update_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();
        $fakeStudyStatus = factory(StudyStatus::class)->make()->toArray();

        $updatedStudyStatus = $this->studyStatusRepo->update($fakeStudyStatus, $studyStatus->id);

        $this->assertModelData($fakeStudyStatus, $updatedStudyStatus->toArray());
        $dbStudyStatus = $this->studyStatusRepo->find($studyStatus->id);
        $this->assertModelData($fakeStudyStatus, $dbStudyStatus->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_study_status()
    {
        $studyStatus = factory(StudyStatus::class)->create();

        $resp = $this->studyStatusRepo->delete($studyStatus->id);

        $this->assertTrue($resp);
        $this->assertNull(StudyStatus::find($studyStatus->id), 'StudyStatus should not exist in DB');
    }
}
