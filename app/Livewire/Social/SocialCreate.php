<?php

namespace App\Livewire\Social;

use App\Models\Social;
use Livewire\Component;

class SocialCreate extends Component
{
    public $openModal=false;
    public $socials=[];
    public $url,$social_id;
    protected $rules=['url'=>'required','social_id'=>'required'];

    public function addSocial(){
        $data = $this->validate();
        $this->openModal = False;
        $user = auth()->user();
        $user->socials()->attach([$this->social_id=>['url'=>$this->url]]);
        $this->emitTo('social.social-delete','reloadSocial');


    }


    public function render()
    {
        $this->socials = Social::orderBy('name','asc')->get();

        return view('livewire.social.social-create');
    }
}
