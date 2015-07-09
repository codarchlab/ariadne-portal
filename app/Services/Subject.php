<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;
use App\Services\ElasticSearch;

class Subject {

    /**
     * Get statistics of number of values for each subject
     * @return Array information for each subject
     */
    public static function statistics() {
        $subjects = DB::table('ariadne_subject')
                ->select('ariadne_subject.id', 'ariadne_subject.name')
                ->orderBy('ariadne_subject.name')
                ->get();
        
        foreach($subjects as &$subject){
            $subject->collections = Utils::getSubjectCount($subject->id, Utils::getDataResourceType('collection'));
            $subject->datasets = Utils::getSubjectCount($subject->id, Utils::getDataResourceType('dataset'));
            $subject->databases = Utils::getSubjectCount($subject->id, Utils::getDataResourceType('database'));
            $subject->gis = Utils::getSubjectCount($subject->id, Utils::getDataResourceType('gis'));
        }

        return $subjects;
    }
    
    public static function statisticsWithES() {
        
        $subjects = Utils::geAriadneSubjectsES();        
               
        foreach($subjects as &$subject){
             $query = ['query'=>
                          ['match' => ['archaeologicalResourceType.name' => $subject['_source']['name']]]
                     ];
 
            $subject['collections'] = ElasticSearch::countHits($query, 'resource', 'collection');
            $subject['datasets'] = ElasticSearch::countHits($query, 'resource', 'dataset');
            $subject['databases'] = ElasticSearch::countHits($query, 'resource', 'database');
            $subject['gis'] = ElasticSearch::countHits($query, 'resource', 'gis');
            $subject['textualDocument'] = ElasticSearch::countHits($query, 'resource', 'textualDocument');
        }

        return $subjects;
    }
    
    public static function resourceWithSubject($subjectId,$type) {
         
        
        $query = ['query'=>
                     ['match' => ['archaeologicalResourceType.id' => $subjectId]]
                ];
               
        $resources = ElasticSearch::allResourcePaginated($query, 'resource', $type);
              
        return $resources;
    }

}
