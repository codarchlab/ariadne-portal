<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;
use App\Services\AriadneType;

class Provider {

    public static function statistics() {
        $users = explode(',', getenv('PROVIDERS'));

        $providers = DB::table('users')
                ->select('users.id', 'users.name')
                ->orderBy('users.name')
                ->whereIn('users.id', $users)
                ->get();

        foreach ($providers as &$provider) {
            $provider->collections = Utils::getTableCount("DataResource", $provider->id, Utils::getDataResourceType('collection'));
            $provider->datasets = Utils::getTableCount("DataResource", $provider->id, Utils::getDataResourceType('dataset'));
            $provider->databases = Utils::getTableCount("DataResource", $provider->id, Utils::getDataResourceType('database'));
            $provider->gis = Utils::getTableCount("DataResource", $provider->id, Utils::getDataResourceType('gis'));
            $provider->schemas = Utils::getTableCount("MetadataSchema", $provider->id);
            $provider->services = Utils::getTableCount("ARIADNEService", $provider->id);
            $provider->vocabularies = Utils::getTableCount("Vocabulary", $provider->id);
            $provider->foaf = Utils::getTableCount("foafAgent", $provider->id);
        }
        return $providers;
    }

    /**
     * Get name for a provider
     *
     * @param int $id ID of provider
     * @return string Name of provider
     */
    public static function getName($id) {
        
        $name = DB::table('users')
                ->select('users.name')                
                ->where('users.id', $id)
                ->pluck('name');
        
        return $name;
    }
    
}
