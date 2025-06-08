<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TargetResource\Pages;
use App\Filament\Admin\Resources\TargetResource\RelationManagers;
use App\Models\Target;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TargetResource extends Resource
{
    protected static ?string $model = Target::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationGroup = 'Company Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_id')
                    ->default(1)
                    ->hidden(),
                Forms\Components\Select::make('period_id')
                    ->relationship('period', 'name')
                    ->searchable()
                    ->default(null),
                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'location')
                    ->default(null),
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name') // atau nama lain yang ditampilkan
                    ->required()
                    ->reactive(),
                Forms\Components\TextInput::make('targetprod')
                    ->label('Quantity')
                    ->minValue(1)
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $product = \App\Models\Product::find($get('product_id'));
                        $price = $product?->price ?? 0;
                        $set('total', $price * (int) $state);
                }),
                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->disabled()
                    ->dehydrated() // supaya nilainya tetap masuk ke database
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('period.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.location')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('targetprod')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('period_id', 'asc') 
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
            'index' => Pages\ListTargets::route('/'),
            'create' => Pages\CreateTarget::route('/create'),
            'edit' => Pages\EditTarget::route('/{record}/edit'),
        ];
    }
}
