<?php

namespace App\Filament\Resources\Admin\ItemResource\Pages;

use App\Filament\Resources\Admin\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;
}
