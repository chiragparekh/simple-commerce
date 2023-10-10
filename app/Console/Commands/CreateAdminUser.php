<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;
use function Laravel\Prompts\info;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commerce:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'What is name of User?',
            placeholder: 'John Doe',
            required: true,
        );

        $email = text(
            label: 'Provide email address for user',
            placeholder: 'john@doe.com',
            required: true,
        );

        $password = password(
            label: 'Enter Password for User?',
            placeholder: 'password',
            hint: 'Minimum 8 characters.'
        );

        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->email_verified_at = now();
        $user->password = Hash::make($password);
        $user->remember_token = Str::random(10);

        $user->save();

        $user->assignRole(Role::ADMIN->value);

        info('Admin user created with provided details.');
    }
}
