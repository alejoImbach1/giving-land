<?php

namespace App\Livewire\Profile\Edit;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProfileImg extends Component
{
    public $profile, $editDisplayed, $deleteDisplayed;


    public function mount(){
        $this->profile = Auth::user()->profile;
        $this->editDisplayed = $this->deleteDisplayed = false;
    }

    public function edit()
    {
        $this->editDisplayed = true;
    }

    public function dialogDeletePhoto()
    {
        $this->deleteDisplayed = true;
    }

    public function deletePhoto()
    {
        Storage::delete('public/users_profile_images/' . $this->profile->image->url);
        $this->profile->image->update([
            'url' => 'default.svg'
        ]);

        Utility::sendAlert('warning', 'Se eliminó tu foto de perfil');

        return to_route('profile.edit');
    }

    public function render()
    {
        // $this->editDisplayed = false;
        return view('livewire.profile.edit.profile-img');
    }
}
