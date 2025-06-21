<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Filament\Admin\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Sales Management';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = -2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->default(1)
                    ->hidden(),
                Forms\Components\Select::make('user_id')
                    ->label('Client Name')
                    ->relationship('user', 'name', function ($query) {
                        $query->whereHas('client', function ($subQuery) {
                            $subQuery->where('division_id', '1');
                        });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'location')
                    ->default(null),
                Forms\Components\Select::make('division_id')
                    ->relationship('division', 'name')
                    ->default(1)
                    ->disabled()
                    ->label('Division'),
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'name', function ($query, $get) {
                        $query->where('division_id', 1);
                
                        if ($get('branch_id')) {
                            $query->where('branch_id', $get('branch_id'));
                        }
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name ?? '-')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->prefix('+62')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branch.location')
                    ->label('Branch')
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Division')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.user.name')
                    ->label('Employee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
