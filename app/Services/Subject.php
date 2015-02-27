<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

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
            $subject->collections = Utils::getSubjectCount($subject->id, 0);
            $subject->datasets = Utils::getSubjectCount($subject->id, 1);
            $subject->databases = Utils::getSubjectCount($subject->id, 2);
            $subject->gis = Utils::getSubjectCount($subject->id, 3);
        }

        return $subjects;
    }

}
