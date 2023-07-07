<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PainelController extends Controller
{
    public function index()
    {

        $user_id = auth('sanctum')->user()->id;

        $ret = DB::select('select count(*) as qtddoc, sum(docsize) as diskspace from documentos where user_id = ?', [$user_id]);

        $ret = array(
            'qtddoc' => $ret[0]->qtddoc,
            'diskspace' => round(($ret[0]->diskspace/1024)/1024,2)
        );

        return view('dashboard',[
            'painel' => $ret,
        ]);

    }
}
