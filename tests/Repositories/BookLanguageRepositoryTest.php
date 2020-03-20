<?php namespace Tests\Repositories;

use App\Models\BookLanguage;
use App\Repositories\BookLanguageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BookLanguageRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BookLanguageRepository
     */
    protected $bookLanguageRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bookLanguageRepo = \App::make(BookLanguageRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->make()->toArray();

        $createdBookLanguage = $this->bookLanguageRepo->create($bookLanguage);

        $createdBookLanguage = $createdBookLanguage->toArray();
        $this->assertArrayHasKey('id', $createdBookLanguage);
        $this->assertNotNull($createdBookLanguage['id'], 'Created BookLanguage must have id specified');
        $this->assertNotNull(BookLanguage::find($createdBookLanguage['id']), 'BookLanguage with given id must be in DB');
        $this->assertModelData($bookLanguage, $createdBookLanguage);
    }

    /**
     * @test read
     */
    public function test_read_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();

        $dbBookLanguage = $this->bookLanguageRepo->find($bookLanguage->id);

        $dbBookLanguage = $dbBookLanguage->toArray();
        $this->assertModelData($bookLanguage->toArray(), $dbBookLanguage);
    }

    /**
     * @test update
     */
    public function test_update_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();
        $fakeBookLanguage = factory(BookLanguage::class)->make()->toArray();

        $updatedBookLanguage = $this->bookLanguageRepo->update($fakeBookLanguage, $bookLanguage->id);

        $this->assertModelData($fakeBookLanguage, $updatedBookLanguage->toArray());
        $dbBookLanguage = $this->bookLanguageRepo->find($bookLanguage->id);
        $this->assertModelData($fakeBookLanguage, $dbBookLanguage->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();

        $resp = $this->bookLanguageRepo->delete($bookLanguage->id);

        $this->assertTrue($resp);
        $this->assertNull(BookLanguage::find($bookLanguage->id), 'BookLanguage should not exist in DB');
    }
}
