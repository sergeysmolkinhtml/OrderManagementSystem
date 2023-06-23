<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public User $user;

    public ?string $password = '';

    public ?string $passwordConfirmation = '';

    public bool $showModal = false;

    protected function rules() : array
    {
        return [
            'user.name'  => ['required', 'string', 'min:3'],
            'user.email' => ['required', 'email', 'string'],
            'password'   => ['required', 'string', 'min:8', Password::defaults()],
            'passwordConfirmation' => ['required','same:password']
        ];
    }

    public function render()
    {
        $users = User::paginate(10);
        $invitations = Invitation::latest()->get();

        return view('livewire.users-list', [
            'users' => $users,
            'invitations' => $invitations
        ]);
    }

    public function save()
    {
        $this->validate();

        User::create([
           'name' => $this->user->name,
           'email' => $this->user->email,
           'password' => bcrypt($this->password)
       ]);

        $this->reset('showModal');
    }

    public function sendInvitation(StoreUserRequest $request) : RedirectResponse
    {
        $invitation = Invitation::create([
            'tenant_id' => auth()->user()->current_tenant_id,
            'email' => $request->email,
            'token' => Str::random(32)
        ]);

        return redirect()->route('users.index');
    }
    public function openModal()
    {
        $this->showModal = true;

        $this->user = new User();
    }

}
