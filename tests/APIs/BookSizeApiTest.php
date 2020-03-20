<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BookSize;

class BookSizeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_book_size()
    {
        $bookSize = factory(BookSize::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/book_sizes', $bookSize
        );

        $this->assertApiResponse($bookSize);
    }

    /**
     * @test
     */
    public function test_read_book_size()
    {
        $bookSize = factory(BookSize::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/book_sizes/'.$bookSize->id
        );

        $this->assertApiResponse($bookSize->toArray());
    }

    /**
     * @test
     */
    public function test_update_book_size()
    {
        $bookSize = factory(BookSize::class)->create();
        $editedBookSize = factory(BookSize::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/book_sizes/'.$bookSize->id,
            $editedBookSize
        );

        $this->assertApiResponse($editedBookSize);
    }

    /**
     * @test
     */
    public function test_delete_book_size()
    {
        $bookSize = factory(BookSize::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/book_sizes/'.$bookSize->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/book_sizes/'.$bookSize->id
        );

        $this->response->assertStatus(404);
    }
}
