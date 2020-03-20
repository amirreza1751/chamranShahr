<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BookEdition;

class BookEditionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/book_editions', $bookEdition
        );

        $this->assertApiResponse($bookEdition);
    }

    /**
     * @test
     */
    public function test_read_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/book_editions/'.$bookEdition->id
        );

        $this->assertApiResponse($bookEdition->toArray());
    }

    /**
     * @test
     */
    public function test_update_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();
        $editedBookEdition = factory(BookEdition::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/book_editions/'.$bookEdition->id,
            $editedBookEdition
        );

        $this->assertApiResponse($editedBookEdition);
    }

    /**
     * @test
     */
    public function test_delete_book_edition()
    {
        $bookEdition = factory(BookEdition::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/book_editions/'.$bookEdition->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/book_editions/'.$bookEdition->id
        );

        $this->response->assertStatus(404);
    }
}
