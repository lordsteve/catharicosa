<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $timezone;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|max:255|confirmed'
    ];

    public function updated($propertyName)
    {
        $propertyName === 'password_confirmation'
            ? $propertyName = 'password'
            : $propertyName = $propertyName;

        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'timezone' => $this->timezone
        ]);

        auth()->login($user);

        DB::table('users')->where('email', $user->email)->update([
            'timezone' => $this->timezone,
        ]);

        return redirect('/')->with('success', 'Welcome, traveler!<br />Your information has been recorded. Now, go! Enjoy yourself!');
    }

    public function render()
    {
        return view('livewire.register')->layout('components.layout');
    }
}
