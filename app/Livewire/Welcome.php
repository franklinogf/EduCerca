<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
class Welcome extends Component
{
    use Toast;

    public string $email = 'teacher@demo.com';
    public string $password = '123456';
    public string $selectedTab = 'teacher';
    public bool $loginModal = false;
    public bool $signingIn = false;


    public function login()
    {
        $this->signingIn = true;

        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard($this->selectedTab)->attempt($validated)) {
            return $this->redirect(route("dashboard.{$this->selectedTab}.home"), navigate: true);
        }

        $this->error(
            'Error al iniciar sessión',
            timeout: 5000,
            position: 'toast-bottom'
        );
        $this->signingIn = false;

    }

    public function render()
    {
        $loginOptions = [['id' => 'teacher', 'name' => 'Profesor'], ['id' => 'parent', 'name' => 'Padres']];
        return view('livewire.welcome', ['loginOptions' => $loginOptions]);
    }
}
