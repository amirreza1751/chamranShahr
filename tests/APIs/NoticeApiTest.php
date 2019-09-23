<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Notice;

class NoticeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_notice()
    {
        $notice = factory(Notice::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/notices', $notice
        );

        $this->assertApiResponse($notice);
    }

    /**
     * @test
     */
    public function test_read_notice()
    {
        $notice = factory(Notice::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/notices/'.$notice->id
        );

        $this->assertApiResponse($notice->toArray());
    }

    /**
     * @test
     */
    public function test_update_notice()
    {
        $notice = factory(Notice::class)->create();
        $editedNotice = factory(Notice::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/notices/'.$notice->id,
            $editedNotice
        );

        $this->assertApiResponse($editedNotice);
    }

    /**
     * @test
     */
    public function test_delete_notice()
    {
        $notice = factory(Notice::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/notices/'.$notice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/notices/'.$notice->id
        );

        $this->response->assertStatus(404);
    }
}
