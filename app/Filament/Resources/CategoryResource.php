<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open'; // Ganti icon script

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                    ->required() // wajib diisi / ditambahkan
                    // ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))) // jadi web-dev dari STR
                    // ->Live(debounce: 250) // delay
                    ->maxLength(255),

                // Forms\Components\TextInput::make('slug')
                //     ->required()
                //     ->disabled(),

                Forms\Components\FileUpload::make('icon')
                    ->image() // wajib isinya gambar
                    ->required() // wajib diisi
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table // VIEW
            ->columns([
                // Munculin data difilament
                Tables\Columns\TextColumn::make('name')
                    ->searchAble(), // Form search
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('icon'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
