<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class SimpleSearch {
    
     public static function getType($typeId) {
         
        $typeName = Utils::getDataResourceTypeName($typeId);
        $type = array('id' => $typeId, 'name' => $typeName);
        
        return $type;
    }
    
    
}
