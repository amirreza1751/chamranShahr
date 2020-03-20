<?php namespace Tests\Repositories;

use App\Models\Ad;
use App\Repositories\AdRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AdRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AdRepository
     */
    protected $adRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->adRepo = \App::make(AdRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_ad()
    {
        $ad = factory(Ad::class)->make()->toArray();

        $createdAd = $this->adRepo->create($ad);

        $createdAd = $createdAd->toArray();
        $this->assertArrayHasKey('id', $createdAd);
        $this->assertNotNull($createdAd['id'], 'Created Ad must have id specified');
        $this->assertNotNull(Ad::find($createdAd['id']), 'Ad with given id must be in DB');
        $this->assertModelData($ad, $createdAd);
    }

    /**
     * @test read
     */
    public function test_read_ad()
    {
        $ad = factory(Ad::class)->create();

        $dbAd = $this->adRepo->find($ad->id);

        $dbAd = $dbAd->toArray();
        $this->assertModelData($ad->toArray(), $dbAd);
    }

    /**
     * @test update
     */
    public function test_update_ad()
    {
        $ad = factory(Ad::class)->create();
        $fakeAd = factory(Ad::class)->make()->toArray();

        $updatedAd = $this->adRepo->update($fakeAd, $ad->id);

        $this->assertModelData($fakeAd, $updatedAd->toArray());
        $dbAd = $this->adRepo->find($ad->id);
        $this->assertModelData($fakeAd, $dbAd->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_ad()
    {
        $ad = factory(Ad::class)->create();

        $resp = $this->adRepo->delete($ad->id);

        $this->assertTrue($resp);
        $this->assertNull(Ad::find($ad->id), 'Ad should not exist in DB');
    }
}
