<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManagerLeadResource;
use App\Models\Manager;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagerController extends Controller
{
    public function __invoke(Manager $manager): AnonymousResourceCollection
    {
        $leads = $manager->leads()
            ->withCount('calls')
            ->withSum('calls', 'duration')
            ->paginate(16);

        return ManagerLeadResource::collection($leads);
    }
}
