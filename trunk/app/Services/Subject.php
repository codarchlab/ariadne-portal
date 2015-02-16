<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Subject {

    public static function statistics() {
        $subjects = DB::table('ariadne_subject')
                ->select('ariadne_subject.id', 'ariadne_subject.name')
                ->orderBy('ariadne_subject.name')
                ->get();

        return $subjects;
    }

}
