<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Widgets;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\OrderStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
