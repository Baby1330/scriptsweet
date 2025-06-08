<?php

namespace App\Filament\Admin\Resources\PeriodResource\Pages;

use App\Filament\Admin\Resources\PeriodResource;
use Filament\Actions;
use App\Models\Period;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;


class CreatePeriod extends CreateRecord
{
    protected static string $resource = PeriodResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $year = $data['year'];

        for ($month = 1; $month <= 12; $month++) {
            Period::firstOrCreate([
                'year' => $year,
                'month' => $month,
            ], [
                'name' => Carbon::createFromDate($year, $month, 1)->format('F Y'),
            ]);
        }

        $this->redirect(PeriodResource::getUrl());

        // Return dummy model (ambil salah satu atau baru)
        return Period::first();
    }
}
