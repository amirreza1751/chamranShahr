<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Term;

class TermApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_term()
    {
        $term = factory(Term::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/terms', $term
        );

        $this->assertApiResponse($term);
    }

    /**
     * @test
     */
    public function test_read_term()
    {
        $term = factory(Term::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/terms/'.$term->id
        );

        $this->assertApiResponse($term->toArray());
    }

    /**
     * @test
     */
    public function test_update_term()
    {
        $term = factory(Term::class)->create();
        $editedTerm = factory(Term::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/terms/'.$term->id,
            $editedTerm
        );

        $this->assertApiResponse($editedTerm);
    }

    /**
     * @test
     */
    public function test_delete_term()
    {
        $term = factory(Term::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/terms/'.$term->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/terms/'.$term->id
        );

        $this->response->assertStatus(404);
    }
}
