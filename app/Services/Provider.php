<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

abstract class AriadneType {
    const collection = 0;
    const dataset = 1;
    const database = 2;
    const gis = 3;
}

class Provider {

    public static function statistics() {
        $users = explode(',', getenv('PROVIDERS'));

        $providers = DB::table('users')
                ->select('users.id', 'users.name')
                ->orderBy('users.name')
                ->whereIn('users.id', $users)
                ->get();

        foreach ($providers as &$provider) {
            $provider->collections = Utils::getTableCount("DataResource", $provider->id, AriadneType::collection);
            $provider->datasets = Utils::getTableCount("DataResource", $provider->id, AriadneType::dataset);
            $provider->databases = Utils::getTableCount("DataResource", $provider->id, AriadneType::database);
            $provider->gis = Utils::getTableCount("DataResource", $provider->id, AriadneType::gis);
            $provider->schemas = Utils::getTableCount("MetadataSchema", $provider->id);
            $provider->services = Utils::getTableCount("ARIADNEService", $provider->id);
            $provider->vocabularies = Utils::getTableCount("Vocabulary", $provider->id);
            $provider->foaf = Utils::getTableCount("foafAgent", $provider->id);
        }
        return $providers;
    }

}
