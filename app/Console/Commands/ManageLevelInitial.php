<?php

namespace App\Console\Commands;

use App\Repositories\ManageLevelRepository;
use Illuminate\Console\Command;

class ManageLevelInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage_level:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill manage_level table with basic information';

    /** @var  ManageLevelRepository */
    private $manageLevelRepository;

    /**
     * Create a new command instance.
     *
     * @param ManageLevelRepository $manageLevelRepo
     */
    public function __construct(ManageLevelRepository $manageLevelRepo)
    {
        parent::__construct();
        $this->manageLevelRepository = $manageLevelRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $level = array(
          'management_title' => 'ریاست دانشگاه',
          'english_management_title' => 'University Presidency',
          'manager_title' => 'رییس دانشگاه',
          'english_manager_title' => 'University President',
          'level' => 1.0,
        );
        $manageLevel = $this->manageLevelRepository->create($level);

        $level = array(
            'management_title' => 'معاونت دانشگاه',
            'english_management_title' => 'University Vice Presidency',
            'manager_title' => 'معاون دانشگاه',
            'english_manager_title' => 'University Vice President',
            'level' => 2.0,
        );
        $manageLevel = $this->manageLevelRepository->create($level);

        $level = array(
            'management_title' => 'مدیریت',
            'english_management_title' => 'Management',
            'manager_title' => 'مدیر',
            'english_manager_title' => 'Manager',
            'level' => 3.0,
        );
        $manageLevel = $this->manageLevelRepository->create($level);

        $level = array(
            'management_title' => 'ریاست دانشکده',
            'english_management_title' => 'Faculty Presidency',
            'manager_title' => 'رئیس دانشکده',
            'english_manager_title' => 'Faculty President',
            'level' => 3.5,
        );
        $manageLevel = $this->manageLevelRepository->create($level);

        $level = array(
            'management_title' => 'مذیریت کروه',
            'english_management_title' => 'Study Department management',
            'manager_title' => 'مدیر گروه',
            'english_manager_title' => 'Study Department manager',
            'level' => 4.5,
        );
        $manageLevel = $this->manageLevelRepository->create($level);
    }
}
