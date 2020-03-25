<?php namespace Tests\Repositories;

use App\Models\Faculty;
use App\Repositories\FacultyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FacultyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FacultyRepository
     */
    protected $facultyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->facultyRepo = \App::make(FacultyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_faculty()
    {
        $faculty = factory(Faculty::class)->make()->toArray();

        $createdFaculty = $this->facultyRepo->create($faculty);

        $createdFaculty = $createdFaculty->toArray();
        $this->assertArrayHasKey('id', $createdFaculty);
        $this->assertNotNull($createdFaculty['id'], 'Created Faculty must have id specified');
        $this->assertNotNull(Faculty::find($createdFaculty['id']), 'Faculty with given id must be in DB');
        $this->assertModelData($faculty, $createdFaculty);
    }

    /**
     * @test read
     */
    public function test_read_faculty()
    {
        $faculty = factory(Faculty::class)->create();

        $dbFaculty = $this->facultyRepo->find($faculty->id);

        $dbFaculty = $dbFaculty->toArray();
        $this->assertModelData($faculty->toArray(), $dbFaculty);
    }

    /**
     * @test update
     */
    public function test_update_faculty()
    {
        $faculty = factory(Faculty::class)->create();
        $fakeFaculty = factory(Faculty::class)->make()->toArray();

        $updatedFaculty = $this->facultyRepo->update($fakeFaculty, $faculty->id);

        $this->assertModelData($fakeFaculty, $updatedFaculty->toArray());
        $dbFaculty = $this->facultyRepo->find($faculty->id);
        $this->assertModelData($fakeFaculty, $dbFaculty->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_faculty()
    {
        $faculty = factory(Faculty::class)->create();

        $resp = $this->facultyRepo->delete($faculty->id);

        $this->assertTrue($resp);
        $this->assertNull(Faculty::find($faculty->id), 'Faculty should not exist in DB');
    }
}
