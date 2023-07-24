<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Models\Documentos;
use Ramsey\Uuid\Uuid;
use ZipArchive;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Crypt;


class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $user_id = auth('sanctum')->user()->id;

        $globalSearch = AllowedFilter::callback('global', function ($query,$value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orwhere('titulo', 'LIKE', "%$value%")
                        ->orwhere('descricao', 'LIKE', "%$value%");
                });
            });
        });

        $ret = QueryBuilder::for(Documentos::class)
            ->where('user_id', $user_id)
            ->orderby('created_at', 'desc')
            ->allowedSorts(['titulo', 'datadoc', 'created_at'])
            ->allowedFilters(['titulo', 'datadoc', 'descricao', 'created_at', $globalSearch])
            ->paginate(7)
            ->withQueryString();

        return view('document.result-search-document', [
            'docs' => SpladeTable::for($ret)
                ->withGlobalSearch()
                ->defaultSort('titulo','desc')
                ->column('titulo', label: __('Title'), sortable: true, searchable: true)
                ->column('descricao', label: __('TAGS'), searchable: true)
                ->column('datadoc', hidden: true, searchable: true)
                ->column('created_at', hidden: true,  searchable: true)
                ->column('datadoc', label: __('Date'), sortable: true, searchable: true, as: fn ($datadoc) => date('d/m/Y', strtotime($datadoc)))
                ->column('created_at', label: __('Created at'), sortable: true, searchable: true, as: fn ($datadoc) => date('d/m/Y H:i', strtotime($datadoc)))
                ->column('action', label: '', canBeHidden: true)
        ]);
    }

    /**
     * Display the document's profile form.
     *
     * @return \Illuminate\View\View
     */
    public function new(Request $request)
    {

        $datadoc = date('d/m/Y');

        $doc = array(
            'id' => 0,
            'titulo' => '',
            'descricao' => '',
            'datadoc' => $datadoc,
            'user_id' => auth('sanctum')->user()->id,
            'nomearq' => '',
            'notas' => '',
            'docsize' => 0
        );

        return view('document.new-document-form', [
            'document' => $doc,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'titulo' => 'required|max:254',
            'datadoc' => 'required'
        ]);

        try {

            $doc = $request->all();
        
            $arqs = $request->file('arquivos');

            $datadoc = substr($doc['datadoc'],6,4) . '-' . substr($doc['datadoc'],3,2) . '-' . substr($doc['datadoc'],0,2);

            $zip_file = ''; $totalSize = 0;

            if (!is_null($arqs)) {
                         
                $created = date('Y');
                $destinationPath = public_path('uploads/' . auth('sanctum')->user()->id . '/' . $created);
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                $zip_file = Uuid::uuid4() . '.zip';
                while (file_exists($destinationPath . '/' . $zip_file)) {
                    $zip_file = Uuid::uuid4() . '.zip';
                }

                $destino = $destinationPath . '/' . $zip_file;

                $zip = new ZipArchive();

                $zipStatus = $zip->open($destino, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                if ($zipStatus == true) {

                    $password = Crypt::decryptString(auth('sanctum')->user()->keyword);
                    
                    if (! empty($password)) {
                        if (!$zip->setPassword($password)) {
                            Log::info('Erro na password');
                        }
                    }

                    foreach($arqs as $file) {
                        
                        $zip->addFile($file, basename($file->getClientOriginalName()));
                        if (! empty($password)) {
                            if (!$zip->setEncryptionName( basename($file->getClientOriginalName()), ZipArchive::EM_TRAD_PKWARE, $password)) {
                                Log::info('Erro encrypt ' .  basename($file->getClientOriginalName()));
                            }
                        }

                    }

                    $zip->close();
                    $totalSize = filesize($destino);

                }

            }

            $input = array(
                'id' => $doc['id'],
                'titulo' => $doc['titulo'],
                'descricao' => $doc['descricao'],
                'notas' => $doc['notas'],
                'datadoc' => $datadoc,
                'user_id' => auth('sanctum')->user()->id,
                'nomearq' => $zip_file,
                'docsize' => $totalSize
            );

            Documentos::create($input);

            Toast::title(__('Document created!'))->autoDismiss(5);
    
            return redirect()->route('search');

        } catch (\Exception $e) {

            Log::info($e);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {

        $this->validate($request, [
            'titulo' => 'required|max:254',
            'datadoc' => 'required'
        ]);

        $input = $request->all();

        $docs = Documentos::findOrFail($id);

        if ($docs['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        try {
            
            $docs->fill($input);
            $docs['datadoc'] = substr($input['datadoc'],6,4) . '-' . substr($input['datadoc'],3,2) . '-' . substr($input['datadoc'],0,2);

        } catch (\Exception $e) {

            return response()->json(['messagem' => $e], 422);
            
        }

        $docs->save();

        Toast::title(__('Document saved!'))->autoDismiss(5);

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $id = base64_decode($id . env('DOC_SECRET', '0'));

        $doc = Documentos::findOrFail($id);

        if ($doc['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        $doc['datadoc'] = date('d/m/Y', strtotime($doc['datadoc']));

        return view('document.update-document-form', [
            'document' => $doc,
        ]);
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $id = base64_decode($id . env('DOC_SECRET', '0'));

        $doc = Documentos::findOrFail($id);

        if ($doc['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        return view('document.delete-document-confirm', [
            'document' => $doc,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $doc = Documentos::findOrFail($id);

        if ($doc['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        if (! $doc['nomearq'] == '') {

            $created = date('Y', strtotime($doc['created_at']));
            $filePath = public_path('uploads/' . auth('sanctum')->user()->id . '/' . $created . '/' . $doc['nomearq']);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

        }
        
        $doc->delete();

        Toast::title(__('Document deleted!'))->autoDismiss(5);

        return redirect()->back();
    }

    /**
     * View files from a especific document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {

        $retId = $id;  // encoded Id

        $id = base64_decode($id . env('DOC_SECRET', '0'));

        $doc = Documentos::findOrFail($id);

        if ($doc['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        $file = ''; $list = []; $nomearq = $doc['nomearq'];

        if ($nomearq != '') {
            $created = date('Y', strtotime($doc['created_at']));
            $file = public_path('uploads/' . auth('sanctum')->user()->id . '/' . $created . '/' . $doc['nomearq']);
dd($file);
            if (file_exists($file)) {

                $zip = new ZipArchive();
                
                if ($zip->open($file, \ZipArchive::RDONLY)) {
                    $numfiles = $zip->count();

                    for($idx=0; $idx < $numfiles; $idx++) {

                        $parts = explode(DIRECTORY_SEPARATOR, $zip->getNameIndex($idx));
            
                        array_push($list, $parts);
            
                    }
            
                    $zip->close();
                }

            } else {
                $nomearq = '';
            }
        }

        $ret = array(
            "id" => $retId,
            "file" => $nomearq,
            "files" => $list
        );

        return view('document.view-document-files', [
            'ret' => $ret,
        ]);
    }
    
    /**
     * View download a especific document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {

        $id = base64_decode($id . env('DOC_SECRET', '0'));

        $doc = Documentos::findOrFail($id);

        if ($doc['user_id'] != auth('sanctum')->user()->id) {
            abort(404);
        }

        // Path to the file
        $created = date('Y', strtotime($doc['created_at']));
        $path = public_path('uploads/' . auth('sanctum')->user()->id . '/' . $created . '/' . $doc['nomearq']);

        // This is based on file type of $path, but not always needed    
        $mm_type = "application/octet-stream";

        //Set headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: " . $mm_type);
        header("Content-Length: " .(string)(filesize($path)) );
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header("Content-Transfer-Encoding: binary\n");

        // Outputs the content of the file
        readfile($path);
    }
}
