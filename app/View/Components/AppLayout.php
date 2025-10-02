<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $direction = Session::get('direction', 'ltr');
        
        return view('layouts.app', [
            'direction' => $direction,
            'locale' => app()->getLocale()
        ]);
    }
}
