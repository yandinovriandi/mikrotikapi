<?php

namespace App\View\Components;

use App\Models\Company;
use App\Models\Location;
use App\Models\Router;
use App\Models\Server;
use App\Models\Tunnel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $countServer;
    public $tunnelCount;

    public function __construct()
    {
        $this->countServer = Server::get()->count();
        $this->tunnelCount = Tunnel::get()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.sidebar');
    }
}
