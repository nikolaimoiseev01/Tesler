<?php

namespace App\Filament\Resources\Service\ServiceResource\Widgets;

use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use Filament\Widgets\Widget;

class UpdateYC extends Widget
{
    protected static string $view = 'filament.resources.service.service-resource.widgets.update-y-c';

    public function update_all(ServiceYcOperations $req) {
        $services = Service::where('id', 40)->get();
        $req->update($services);
    }

}
