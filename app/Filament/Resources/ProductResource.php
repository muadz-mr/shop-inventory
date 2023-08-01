<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Widgets\StatsOverview;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('product_category_id')
                        ->label('Product Category')
                        ->required()
                        ->options(ProductCategory::all()->pluck('name', 'id')),
                ]),
                Card::make([
                    TextInput::make('name')
                        ->required()
                        ->autocomplete('off')
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->disabled()
                        ->required()
                        ->autocomplete('off')
                        ->unique(Product::class, 'slug', fn ($record) => $record),
                    TextInput::make('brand')
                        ->nullable()
                        ->autocomplete('off'),
                    RichEditor::make('description')
                        ->disableToolbarButtons(['attachFiles', 'codeBlock',])
                        ->nullable(),
                    Select::make('currency_id')
                        ->label('Currency')
                        ->required()
                        ->options(Currency::all()->pluck('name', 'id')),
                    TextInput::make('price')
                        ->placeholder('0.00')
                        ->type('number')
                        ->numeric()
                        ->required()
                        ->rules(['regex:/^\d*(\.?\d{1,2})$/'])
                        ->mask(fn (Mask $mask) => $mask->numeric()->decimalPlaces(2)->decimalSeparator('.')->minValue(0.01)->padFractionalZeros())
                        ->disableAutocomplete(),
                    TextInput::make('quantity')
                        ->type('number')
                        ->integer()
                        ->minValue(0)
                        ->default(0),
                ]),
                Card::make([
                    Radio::make('status')
                        ->required()
                        ->default(ProductStatus::Drafted)
                        ->options([
                            ProductStatus::getKey(ProductStatus::Drafted),
                            ProductStatus::getKey(ProductStatus::Advertised),
                            ProductStatus::getKey(ProductStatus::Sold),
                            ProductStatus::getKey(ProductStatus::Posted),
                        ]),
                    DateTimePicker::make('posted_at')
                        ->label('Posted At')
                        ->withoutSeconds()
                        ->timezone('Asia/Kuala_Lumpur'),
                ]),
                Card::make([
                    FileUpload::make('attachments')
                        ->required()
                        ->directory('product-attachments')
                        ->acceptedFileTypes(['image/png', 'image/jpeg'])
                        ->multiple()
                        ->minFiles(1)
                        ->maxFiles(3)
                        ->enableReordering(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('productCategory.name')
                    ->label('Product Category')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('brand'),
                ImageColumn::make('main_image')->label('Main Image'),
                TextColumn::make('currency.symbol')
                    ->label('Currency'),
                TextColumn::make('price')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->sortable(),
                TextColumn::make('status_description')
                    ->sortable(),
                TextColumn::make('posted_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('brand')
                    ->form([
                        TextInput::make('brand'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->where('brand', 'like', "%{$data['brand']}%");
                    }),
                SelectFilter::make('status')
                    ->options([
                        ProductStatus::getKey(ProductStatus::Drafted),
                        ProductStatus::getKey(ProductStatus::Advertised),
                        ProductStatus::getKey(ProductStatus::Sold),
                        ProductStatus::getKey(ProductStatus::Posted),
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
