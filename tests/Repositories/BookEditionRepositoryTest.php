<?php namespace Tests\Repositories;

use App\Models\BookEdition;
use App\Repositories\BookEditionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookEditionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookEditionRepository
     */
    protected $bookEditionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookEditionRepo = \App::make(BookEditionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->make()->toArray();

        $createdBookEdition = $this->bookEditionRepo->create($bookEdition);

        $createdBookEdition = $createdBookEdition->toArray();
        $this->assertArrayHasKey('id', $createdBookEdition);
        $this->assertNotNull($createdBookEdition['id'], 'Created BookEdition must have id specified');
        $this->assertNotNull(BookEdition::find($createdBookEdition['id']), 'BookEdition with given id must be in DB');
        $this->assertModelData($bookEdition, $createdBookEdition);
    }

    /**
     * @test read
     */
    public function test_read_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();

        $dbBookEdition = $this->bookEditionRepo->find($bookEdition->id);

        $dbBookEdition = $dbBookEdition->toArray();
        $this->assertModelData($bookEdition->toArray(), $dbBookEdition);
    }

    /**
     * @test update
     */
    public function test_update_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();
        $fakeBookEdition = factory(BookEdition::class)->make()->toArray();

        $updatedBookEdition = $this->bookEditionRepo->update($fakeBookEdition, $bookEdition->id);

        $this->assertModelData($fakeBookEdition, $updatedBookEdition->toArray());
        $dbBookEdition = $this->bookEditionRepo->find($bookEdition->id);
        $this->assertModelData($fakeBookEdition, $dbBookEdition->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();

        $resp = $this->bookEditionRepo->delete($bookEdition->id);

        $this->assertTrue($resp);
        $this->assertNull(BookEdition::find($bookEdition->id), 'BookEdition should not exist in DB');
    }
}
