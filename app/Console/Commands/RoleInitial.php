<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class RoleInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate roles table with basic records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cc = new ConsoleColor();
        $gf = new GeneralFunction();
        $cc->print_error("this procedure will truncate \"roles\", \"permissions\", \"role_has_permissions\", \"model_has_permissions\" and \"model_has_roles\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'roles',
                'permissions',
                'role_has_permissions',
                'model_has_permissions',
                'model_has_roles'],
                false);

            $role = Role::create([
                'name' => 'developer',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'client_developer',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'content_manager',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'manager',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'student',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'professor',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");


            $role = Role::create([
                'name' => 'employee',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

            $role = Role::create([
                'name' => 'verified',
                'guard_name' => 'web',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new role:\t" . $cc->getColoredString($role->name, $cc::CREATE) . " for " . $cc->getColoredString($role->guard_name, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
