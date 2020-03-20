<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BookLanguage;

class BookLanguageApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/book_languages', $bookLanguage
        );

        $this->assertApiResponse($bookLanguage);
    }

    /**
     * @test
     */
    public function test_read_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/book_languages/'.$bookLanguage->id
        );

        $this->assertApiResponse($bookLanguage->toArray());
    }

    /**
     * @test
     */
    public function test_update_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();
        $editedBookLanguage = factory(BookLanguage::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/book_languages/'.$bookLanguage->id,
            $editedBookLanguage
        );

        $this->assertApiResponse($editedBookLanguage);
    }

    /**
     * @test
     */
    public function test_delete_book_language()
    {
        $bookLanguage = factory(BookLanguage::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/book_languages/'.$bookLanguage->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/book_languages/'.$bookLanguage->id
        );

        $this->response->assertStatus(404);
    }
}
