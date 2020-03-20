<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Ad;

class AdApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_ad()
    {
        $ad = factory(Ad::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/ads', $ad
        );

        $this->assertApiResponse($ad);
    }

    /**
     * @test
     */
    public function test_read_ad()
    {
        $ad = factory(Ad::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/ads/'.$ad->id
        );

        $this->assertApiResponse($ad->toArray());
    }

    /**
     * @test
     */
    public function test_update_ad()
    {
        $ad = factory(Ad::class)->create();
        $editedAd = factory(Ad::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/ads/'.$ad->id,
            $editedAd
        );

        $this->assertApiResponse($editedAd);
    }

    /**
     * @test
     */
    public function test_delete_ad()
    {
        $ad = factory(Ad::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/ads/'.$ad->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/ads/'.$ad->id
        );

        $this->response->assertStatus(404);
    }
}
