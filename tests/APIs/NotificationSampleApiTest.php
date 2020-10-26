<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\NotificationSample;

class NotificationSampleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/notification_samples', $notificationSample
        );

        $this->assertApiResponse($notificationSample);
    }

    /**
     * @test
     */
    public function test_read_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/notification_samples/'.$notificationSample->id
        );

        $this->assertApiResponse($notificationSample->toArray());
    }

    /**
     * @test
     */
    public function test_update_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();
        $editedNotificationSample = factory(NotificationSample::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/notification_samples/'.$notificationSample->id,
            $editedNotificationSample
        );

        $this->assertApiResponse($editedNotificationSample);
    }

    /**
     * @test
     */
    public function test_delete_notification_sample()
    {
        $notificationSample = factory(NotificationSample::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/notification_samples/'.$notificationSample->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/notification_samples/'.$notificationSample->id
        );

        $this->response->assertStatus(404);
    }
}
