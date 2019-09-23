<?php namespace Tests\Repositories;

use App\Models\Notice;
use App\Repositories\NoticeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class NoticeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var NoticeRepository
     */
    protected $noticeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->noticeRepo = \App::make(NoticeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_notice()
    {
        $notice = factory(Notice::class)->make()->toArray();

        $createdNotice = $this->noticeRepo->create($notice);

        $createdNotice = $createdNotice->toArray();
        $this->assertArrayHasKey('id', $createdNotice);
        $this->assertNotNull($createdNotice['id'], 'Created Notice must have id specified');
        $this->assertNotNull(Notice::find($createdNotice['id']), 'Notice with given id must be in DB');
        $this->assertModelData($notice, $createdNotice);
    }

    /**
     * @test read
     */
    public function test_read_notice()
    {
        $notice = factory(Notice::class)->create();

        $dbNotice = $this->noticeRepo->find($notice->id);

        $dbNotice = $dbNotice->toArray();
        $this->assertModelData($notice->toArray(), $dbNotice);
    }

    /**
     * @test update
     */
    public function test_update_notice()
    {
        $notice = factory(Notice::class)->create();
        $fakeNotice = factory(Notice::class)->make()->toArray();

        $updatedNotice = $this->noticeRepo->update($fakeNotice, $notice->id);

        $this->assertModelData($fakeNotice, $updatedNotice->toArray());
        $dbNotice = $this->noticeRepo->find($notice->id);
        $this->assertModelData($fakeNotice, $dbNotice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_notice()
    {
        $notice = factory(Notice::class)->create();

        $resp = $this->noticeRepo->delete($notice->id);

        $this->assertTrue($resp);
        $this->assertNull(Notice::find($notice->id), 'Notice should not exist in DB');
    }
}
