<?php

namespace App\Http\Livewire;

use ZxcvbnPhp\Zxcvbn;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class RegisterPasswords extends Component
{
    protected const PASSWORD_LENGTH = 12;

    public string $password = '';

    public string $passwordConfirmation = '';

    public int $strengthScore = 0;

    public array $strengthLevels = [
        1 => 'Weak',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Strong',
    ];

    public function updatedPassword($value): void
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    public function generatePassword(): void
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $digits = range(0,9);
        $special = ['!', '@', '#', '$', '%', '^', '*'];
        $chars = array_merge($lowercase, $uppercase, $digits, $special);

        do {
            $password = array();

            for ($i = 0; $i <= self::PASSWORD_LENGTH; $i++) {
                $int = rand(0, count($chars) - 1);
                $password[] = $chars[$int];
            }

        } while (empty(array_intersect($special, $password)));

        $this->setPasswords(implode('', $password));
    }

    protected function setPasswords($value): void
    {
        $this->password = $value;
        $this->passwordConfirmation = $value;
        $this->updatedPassword($value);
    }

    public function render(): View
    {
        return view('livewire.register-passwords');
    }
}
