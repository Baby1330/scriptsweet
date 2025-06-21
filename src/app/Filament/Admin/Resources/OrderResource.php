<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

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
                Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'SO' => 'Sales Order',
                    'PO' => 'Purchase Order',
                    'CO' => 'Cancel Order',
                ])
                ->label('Order Type')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state) return;

                    $prefix = strtoupper($state);

                    $lastOrder = \App\Models\Order::where('order_code', 'like', "$prefix-%")
                        ->latest('id')
                        ->first();

                    if ($lastOrder && preg_match('/\d+$/', $lastOrder->order_code, $matches)) {
                        $number = (int) $matches[0] + 1;
                    } else {
                        $number = 1;
                    }

                    $newCode = $prefix . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
                    $set('order_code', $newCode);
                }),

            Forms\Components\TextInput::make('order_code')
                ->label('Order Code')
                ->disabled()
                ->reactive()
                ->dehydrated()
                ->default('')
                ->visible(fn ($get) => filled($get('status'))),

            Forms\Components\Select::make('employee_id')
                ->required()    
                ->relationship(
                    name: 'employee', // hanya satu tingkat relasi
                    titleAttribute: 'id', // boleh diisi sembarang, nanti di-override
                    modifyQueryUsing: fn ($query) => $query->where('division_id', 1),
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name),
            Forms\Components\Select::make('client_id')
                ->required()
                ->options(function (callable $get) {
                    $empID = $get('employee_id');
                    if (!$empID) {
                        return [];
                    }
            
                    $employee = \App\Models\Employee::find($empID);
                    if (!$employee) {
                        return [];
                    }
            
                    $branch = $employee->branch_id;
            
                    return \App\Models\Client::where('branch_id', $branch)
                        ->pluck('name', 'id')
                        ->toArray();
                })
                ->searchable(),

            Forms\Components\Select::make('product_id')
                ->required()
                ->relationship('product', 'name')
                ->reactive(),
                
            Forms\Components\TextInput::make('qty')
                ->required()
                ->numeric()
                ->minValue(1)
                ->maxValue(10)
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $product = Product::find($get('product_id'));
                    $price = $product?->price ?? 0;
                    $set('grand_total', $price * (int) $state);
            }),

            Forms\Components\TextInput::make('grand_total')
                ->required()
                ->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('order_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.user.name')
                    ->label('Sales')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.user.name')
                    ->label('Client')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
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
                
                Tables\Actions\Action::make('print_invoice')
                ->label('Print Invoice')
                ->icon('heroicon-o-printer')
                ->url(fn (Order $record) => route('orders.invoice', $record))
                ->openUrlInNewTab()
                ->color('gray')
                ->visible(fn (Order $record) => $record->status === 'PO'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
