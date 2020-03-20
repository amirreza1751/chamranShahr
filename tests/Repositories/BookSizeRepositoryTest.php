<?php namespace Tests\Repositories;

use App\Models\BookSize;
use App\Repositories\BookSizeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookSizeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookSizeRepository
     */
    protected $bookSizeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookSizeRepo = \App::make(BookSizeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_book_size()
    {
        $bookSize = factory(BookSize::class)->make()->toArray();

        $createdBookSize = $this->bookSizeRepo->create($bookSize);

        $createdBookSize = $createdBookSize->toArray();
        $this->assertArrayHasKey('id', $createdBookSize);
        $this->assertNotNull($createdBookSize['id'], 'Created BookSize must have id specified');
        $this->assertNotNull(BookSize::find($createdBookSize['id']), 'BookSize with given id must be in DB');
        $this->assertModelData($bookSize, $createdBookSize);
    }

    /**
     * @test read
     */
    public function test_read_book_size()
    {
        $bookSize = factory(BookSize::class)->create();

        $dbBookSize = $this->bookSizeRepo->find($bookSize->id);

        $dbBookSize = $dbBookSize->toArray();
        $this->assertModelData($bookSize->toArray(), $dbBookSize);
    }

    /**
     * @test update
     */
    public function test_update_book_size()
    {
        $bookSize = factory(BookSize::class)->create();
        $fakeBookSize = factory(BookSize::class)->make()->toArray();

        $updatedBookSize = $this->bookSizeRepo->update($fakeBookSize, $bookSize->id);

        $this->assertModelData($fakeBookSize, $updatedBookSize->toArray());
        $dbBookSize = $this->bookSizeRepo->find($bookSize->id);
        $this->assertModelData($fakeBookSize, $dbBookSize->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_book_size()
    {
        $bookSize = factory(BookSize::class)->create();

        $resp = $this->bookSizeRepo->delete($bookSize->id);

        $this->assertTrue($resp);
        $this->assertNull(BookSize::find($bookSize->id), 'BookSize should not exist in DB');
    }
}
