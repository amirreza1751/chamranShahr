<?php namespace Tests\Repositories;

use App\Models\NotificationSample;
use App\Repositories\NotificationSampleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class NotificationSampleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var NotificationSampleRepository
     */
    protected $notificationSampleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->notificationSampleRepo = \App::make(NotificationSampleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->make()->toArray();

        $createdNotificationSample = $this->notificationSampleRepo->create($notificationSample);

        $createdNotificationSample = $createdNotificationSample->toArray();
        $this->assertArrayHasKey('id', $createdNotificationSample);
        $this->assertNotNull($createdNotificationSample['id'], 'Created NotificationSample must have id specified');
        $this->assertNotNull(NotificationSample::find($createdNotificationSample['id']), 'NotificationSample with given id must be in DB');
        $this->assertModelData($notificationSample, $createdNotificationSample);
    }

    /**
     * @test read
     */
    public function test_read_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();

        $dbNotificationSample = $this->notificationSampleRepo->find($notificationSample->id);

        $dbNotificationSample = $dbNotificationSample->toArray();
        $this->assertModelData($notificationSample->toArray(), $dbNotificationSample);
    }

    /**
     * @test update
     */
    public function test_update_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();
        $fakeNotificationSample = factory(NotificationSample::class)->make()->toArray();

        $updatedNotificationSample = $this->notificationSampleRepo->update($fakeNotificationSample, $notificationSample->id);

        $this->assertModelData($fakeNotificationSample, $updatedNotificationSample->toArray());
        $dbNotificationSample = $this->notificationSampleRepo->find($notificationSample->id);
        $this->assertModelData($fakeNotificationSample, $dbNotificationSample->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();

        $resp = $this->notificationSampleRepo->delete($notificationSample->id);

        $this->assertTrue($resp);
        $this->assertNull(NotificationSample::find($notificationSample->id), 'NotificationSample should not exist in DB');
    }
}
