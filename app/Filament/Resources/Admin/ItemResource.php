<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Category;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->readonly()
                    ->default(function () {
                        $currentYear = date('Y');
                        
                        $count = DB::table('items')
                            ->whereYear('created_at', $currentYear)
                            ->count();
                            
                        return "{$currentYear}_" . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
                    }),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->type('number')
                    ->step(0.01)
                    ->inputMode('numeric')
                    ->numeric()
                    ->rules('numeric|min:0'),
                
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->inputMode('numeric')
                    ->maxLength(255),

                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->inputMode('numeric')
                    ->maxLength(255),
                
                Forms\Components\Select::make('category_id')
                    ->required()
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
                    
                Forms\Components\FileUpload::make('image')
                    ->directory('images')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('description')
                ->searchable(),
                Tables\Columns\TextColumn::make('price')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                ->searchable()
                ->sortable()
                ->label('Category'),
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category') 
                    ->options(Category::all()->pluck('name', 'id')->toArray())
                    ->searchable(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
