<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
                
            Forms\Components\TextInput::make('phone') 
                ->numeric()
                ->inputMode('numeric')
                ->required()
                ->maxLength(255),
            
            Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('image')
                ->directory('images')
                ->required(),

            Forms\Components\Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'supplier' => 'Supplier',
                    'customer' => 'Customer',
                ])
                ->required(),
                
            Forms\Components\TextInput::make('password')
            ->password()
            ->revealable()
            ->required()
            ->maxLength(255),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                ->searchable(),
                Tables\Columns\TextColumn::make('address')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                Tables\Columns\TextColumn::make('role')
                ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'supplier' => 'Supplier',
                        'customer' => 'Customer',
                    ]),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
