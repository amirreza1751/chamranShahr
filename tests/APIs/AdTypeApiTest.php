<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AdType;

class AdTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_ad_type()
    {
        $adType = factory(AdType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/ad_types', $adType
        );

        $this->assertApiResponse($adType);
    }

    /**
     * @test
     */
    public function test_read_ad_type()
    {
        $adType = factory(AdType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/ad_types/'.$adType->id
        );

        $this->assertApiResponse($adType->toArray());
    }

    /**
     * @test
     */
    public function test_update_ad_type()
    {
        $adType = factory(AdType::class)->create();
        $editedAdType = factory(AdType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/ad_types/'.$adType->id,
            $editedAdType
        );

        $this->assertApiResponse($editedAdType);
    }

    /**
     * @test
     */
    public function test_delete_ad_type()
    {
        $adType = factory(AdType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/ad_types/'.$adType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/ad_types/'.$adType->id
        );

        $this->response->assertStatus(404);
    }
}
