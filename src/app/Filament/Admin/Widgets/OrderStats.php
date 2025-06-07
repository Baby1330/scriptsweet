<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count()),

            Stat::make('Sales Orders (SO)', Order::where('status', 'SO')->count()),

            Stat::make('Purchase Orders (PO)', Order::where('status', 'PO')->count()),

            Stat::make('Total Sales', 'Rp ' . number_format(
                Order::where('status', 'PO')->sum('grand_total'), 0, ',', '.'
            )),
        ];
    }
}
