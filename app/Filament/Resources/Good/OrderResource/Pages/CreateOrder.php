<?php

namespace App\Filament\Resources\Good\OrderResource\Pages;

use App\Filament\Resources\Good\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}