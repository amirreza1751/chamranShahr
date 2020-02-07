<?php namespace Tests\Repositories;

use App\Models\Term;
use App\Repositories\TermRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TermRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TermRepository
     */
    protected $termRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->termRepo = \App::make(TermRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_term()
    {
        $term = factory(Term::class)->make()->toArray();

        $createdTerm = $this->termRepo->create($term);

        $createdTerm = $createdTerm->toArray();
        $this->assertArrayHasKey('id', $createdTerm);
        $this->assertNotNull($createdTerm['id'], 'Created Term must have id specified');
        $this->assertNotNull(Term::find($createdTerm['id']), 'Term with given id must be in DB');
        $this->assertModelData($term, $createdTerm);
    }

    /**
     * @test read
     */
    public function test_read_term()
    {
        $term = factory(Term::class)->create();

        $dbTerm = $this->termRepo->find($term->id);

        $dbTerm = $dbTerm->toArray();
        $this->assertModelData($term->toArray(), $dbTerm);
    }

    /**
     * @test update
     */
    public function test_update_term()
    {
        $term = factory(Term::class)->create();
        $fakeTerm = factory(Term::class)->make()->toArray();

        $updatedTerm = $this->termRepo->update($fakeTerm, $term->id);

        $this->assertModelData($fakeTerm, $updatedTerm->toArray());
        $dbTerm = $this->termRepo->find($term->id);
        $this->assertModelData($fakeTerm, $dbTerm->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_term()
    {
        $term = factory(Term::class)->create();

        $resp = $this->termRepo->delete($term->id);

        $this->assertTrue($resp);
        $this->assertNull(Term::find($term->id), 'Term should not exist in DB');
    }
}
