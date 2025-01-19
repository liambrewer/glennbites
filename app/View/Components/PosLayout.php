<?php

namespace App\View\Components;

use App\Helpers\NavLink;
use App\Models\Employee;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PosLayout extends Component
{
    readonly public Employee $employee;
    readonly public array $navLinks;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->employee = auth('employee')->user();
        $this->navLinks = [
            NavLink::create(
                href: route('pos.home'),
                icon: 'heroicon-m-home',
                label: 'Home',
                exact: true,
            ),
            NavLink::create(
                href: route('pos.orders.index'),
                icon: 'heroicon-m-rectangle-stack',
                label: 'Orders',
                exact: false,
            ),
            NavLink::create(
                href: route('pos.users.index'),
                icon: 'heroicon-m-users',
                label: 'Users',
                exact: false,
            ),
            NavLink::create(
                href: route('pos.metrics'),
                icon: 'heroicon-m-chart-bar',
                label: 'Metrics',
                exact: false,
            ),
            NavLink::create(
                href: route('pos.activity'),
                icon: 'heroicon-m-clock',
                label: 'Activity Stream',
                exact: true,
            ),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.pos-layout');
    }
}
