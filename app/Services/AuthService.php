<?php

namespace App\Services;

use App\Models\Invitation;


final class AuthService extends ServiceCore
{
    public function __construct() {}
    public function getCreateData($data) : array
    {
        $this->data = $data;
        return $this->data;
    }

    private function setInvitation() : ?string
    {
        $this->invitation = NULL;
        if (request('token')) {
            $this->invitation = Invitation::where('token', request('token'))
                ->whereNull('accepted_at')
                ->firstOrFail();

            $this->invitation = $this->invitation->email;
        }
        return $this->invitation;
    }

    public function getInvitation() : ?string
    {
        return $this->invitation = $this->setInvitation();
    }






}
