<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertModal extends Component
{

    public $type;

    public $message;

    public function __construct()
    {
        // Tomamos de la sesión
        if (session('success')) {
            $this->type = 'success';
            $this->message = session('success');
        } elseif (session('error')) {
            $this->type = 'danger';
            $this->message = session('error');
        } else {
            $this->type = null;
            $this->message = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert-modal');
    }
}
