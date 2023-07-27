<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use App\Notifications\SendInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;

class UsersController extends Component
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

        $invitations = Invitation::where('tenant_id', auth()->user()->current_tenant_id)
            ->latest()
            ->get();

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

        Notification::route('mail', $request->email)
            ->notify(new SendInvitationNotification($invitation));

        return redirect()->route('users.index');
    }

    public function acceptInvitation($token) : \Illuminate\Foundation\Application | \Illuminate\Routing\Redirector | RedirectResponse | \Illuminate\Contracts\Foundation\Application
    {
        $invitation = Invitation::with('tenant')
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if (auth()->check()) {
            $invitation->update(['accepted_at' => now()]);

            auth()->user()->tenants()->attach($invitation->tenant_id);

            auth()->user()->update(['current_tenant_id' => $invitation->tenant_id]);

            $tenantDomain = str_replace('://', '://' . $invitation->tenant->subdomain . '.', config('app.url'));

            return redirect($tenantDomain . RouteServiceProvider::HOME);

        } else {

            return redirect()->route('register', ['token' => $invitation->token]);

        }
    }

    public function openModal() : void
    {
        $this->showModal = true;

        $this->user = new User();
    }

}
