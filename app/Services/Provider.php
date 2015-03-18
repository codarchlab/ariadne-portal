<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Provider {

    /**
     * Get statistics for each provider
     * 
     * @return Array list of prividers with statistics
     */
    public static function statistics() {
        $users = explode(',', getenv('PROVIDERS'));

        $providers = DB::table('users')
                ->select('users.id', 'users.name')
                ->orderBy('users.name')
                ->whereIn('users.id', $users)
                ->get();

        foreach ($providers as &$provider) {
            $provider->collections = Utils::getTableCountByUser("DataResource", $provider->id, Utils::getDataResourceType('collection'));
            $provider->datasets = Utils::getTableCountByUser("DataResource", $provider->id, Utils::getDataResourceType('dataset'));
            $provider->databases = Utils::getTableCountByUser("DataResource", $provider->id, Utils::getDataResourceType('database'));
            $provider->gis = Utils::getTableCountByUser("DataResource", $provider->id, Utils::getDataResourceType('gis'));
            $provider->schemas = Utils::getTableCountByUser("MetadataSchema", $provider->id);
            $provider->services = Utils::getTableCountByUser("ARIADNEService", $provider->id);
            $provider->vocabularies = Utils::getTableCountByUser("Vocabulary", $provider->id);
            $provider->foaf = Utils::getTableCountByUser("foafAgent", $provider->id);
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
    
    /**
     * Get list of providers
     * 
     * @return Array list of providers
     */
    public static function all(){
        $users = explode(',', getenv('PROVIDERS'));
        $providers = DB::table('users')
                        ->select('name')                
                        ->whereIn('id', $users)
                        ->get();
        
        return $providers;
    }
    
}
