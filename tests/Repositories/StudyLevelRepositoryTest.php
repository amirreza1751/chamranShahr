<?php namespace Tests\Repositories;

use App\Models\StudyLevel;
use App\Repositories\StudyLevelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StudyLevelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StudyLevelRepository
     */
    protected $studyLevelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->studyLevelRepo = \App::make(StudyLevelRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->make()->toArray();

        $createdStudyLevel = $this->studyLevelRepo->create($studyLevel);

        $createdStudyLevel = $createdStudyLevel->toArray();
        $this->assertArrayHasKey('id', $createdStudyLevel);
        $this->assertNotNull($createdStudyLevel['id'], 'Created StudyLevel must have id specified');
        $this->assertNotNull(StudyLevel::find($createdStudyLevel['id']), 'StudyLevel with given id must be in DB');
        $this->assertModelData($studyLevel, $createdStudyLevel);
    }

    /**
     * @test read
     */
    public function test_read_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();

        $dbStudyLevel = $this->studyLevelRepo->find($studyLevel->id);

        $dbStudyLevel = $dbStudyLevel->toArray();
        $this->assertModelData($studyLevel->toArray(), $dbStudyLevel);
    }

    /**
     * @test update
     */
    public function test_update_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();
        $fakeStudyLevel = factory(StudyLevel::class)->make()->toArray();

        $updatedStudyLevel = $this->studyLevelRepo->update($fakeStudyLevel, $studyLevel->id);

        $this->assertModelData($fakeStudyLevel, $updatedStudyLevel->toArray());
        $dbStudyLevel = $this->studyLevelRepo->find($studyLevel->id);
        $this->assertModelData($fakeStudyLevel, $dbStudyLevel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_study_level()
    {
        $studyLevel = factory(StudyLevel::class)->create();

        $resp = $this->studyLevelRepo->delete($studyLevel->id);

        $this->assertTrue($resp);
        $this->assertNull(StudyLevel::find($studyLevel->id), 'StudyLevel should not exist in DB');
    }
}
