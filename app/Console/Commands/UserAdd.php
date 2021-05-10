<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\UserService;
use Illuminate\Validation\Rules;


class UserAdd extends Command
{
    protected $signature = 'user:add';

    protected $description = 'Create new user';

    /**
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('E-mail?');
        $phone = $this->ask('Phone number?');
        $password = $this->secret('Password?');
        $password_confirmation = $this->secret('Password?');

        // validate
        $validator = $this->getValidator(compact('phone', 'email', 'password', 'password_confirmation'));
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->error($validator->errors());
            return 1;
        }

        // if ( ! $this->confirm('Do you wish to create user?', true)) {
        //     $this->info('Cancelled!');
        //     return 1;
        // }

        // create user
        $data = $validator->validated();
        $user = UserService::create($data['phone'], $data['email'], $data['password']);

        $this->info("User with id:{$user->id} added!");

        return 0;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidator(array $data)
    {
        return Validator::make($data, [
            // todo: add phone number validator
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(5)],
        ]);
    }

}
