<?php namespace Tests\Repositories;

use App\Models\StudyArea;
use App\Repositories\StudyAreaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StudyAreaRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StudyAreaRepository
     */
    protected $studyAreaRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->studyAreaRepo = \App::make(StudyAreaRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_study_area()
    {
        $studyArea = factory(StudyArea::class)->make()->toArray();

        $createdStudyArea = $this->studyAreaRepo->create($studyArea);

        $createdStudyArea = $createdStudyArea->toArray();
        $this->assertArrayHasKey('id', $createdStudyArea);
        $this->assertNotNull($createdStudyArea['id'], 'Created StudyArea must have id specified');
        $this->assertNotNull(StudyArea::find($createdStudyArea['id']), 'StudyArea with given id must be in DB');
        $this->assertModelData($studyArea, $createdStudyArea);
    }

    /**
     * @test read
     */
    public function test_read_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();

        $dbStudyArea = $this->studyAreaRepo->find($studyArea->id);

        $dbStudyArea = $dbStudyArea->toArray();
        $this->assertModelData($studyArea->toArray(), $dbStudyArea);
    }

    /**
     * @test update
     */
    public function test_update_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();
        $fakeStudyArea = factory(StudyArea::class)->make()->toArray();

        $updatedStudyArea = $this->studyAreaRepo->update($fakeStudyArea, $studyArea->id);

        $this->assertModelData($fakeStudyArea, $updatedStudyArea->toArray());
        $dbStudyArea = $this->studyAreaRepo->find($studyArea->id);
        $this->assertModelData($fakeStudyArea, $dbStudyArea->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_study_area()
    {
        $studyArea = factory(StudyArea::class)->create();

        $resp = $this->studyAreaRepo->delete($studyArea->id);

        $this->assertTrue($resp);
        $this->assertNull(StudyArea::find($studyArea->id), 'StudyArea should not exist in DB');
    }
}
