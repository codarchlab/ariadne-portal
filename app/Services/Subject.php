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
        $subjects = DB::table('ariadne_subject')
                ->select('ariadne_subject.id', 'ariadne_subject.name')
                ->orderBy('ariadne_subject.name')
                ->get();
        
        foreach($subjects as &$subject){
            $query = ['query'=>
                ['match' => 
                    ['ariadne:subject' => [
                            'query' => $subject->name,
                            'cutoff_frequency' => 0.001
                        ]
                    ]
                ]
             ];
 
            $subject->collections = ElasticSearch::ariadneSubject($query, 'dataresources', 'collection');
            $subject->datasets = ElasticSearch::ariadneSubject($query, 'dataresources', 'dataset');
            $subject->databases = ElasticSearch::ariadneSubject($query, 'dataresources', 'database');
            $subject->gis = ElasticSearch::ariadneSubject($query, 'dataresources', 'gis');
        }

        return $subjects;
    }

}
