<?php

namespace Ndeblauw\BlueAdmin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BlueAdminController extends Controller
{
    protected $config;

    public function dashboard()
    {
        return view()->first(['admin.dashboard','BlueAdminPages::dashboard']);
    }

    public function index($modelname)
    {
        $this->setConfig($modelname);

        return view('BlueAdminPages::index')
                    ->with('icon', $this->config->icon )
        			->with('columns', $this->config->index_columns() )
                    ->with('initial_ordering', $this->config->index_initial_ordering() )
                    ->with('actions_col_nr', $this->config->index_actions_column_nr() )
        			->with('title', ucfirst($modelname))
        			->with('modelname', $modelname);
                    // for now without widgets->with('widgets', $this->config->widgets() ?? []);
    }

    public function api_index($modelname)
    {
        $this->setConfig($modelname);

        $mapper = $this->config->index_columns()->where('type', 'belongsto')->values();

        $model = $this->config->model::with($mapper->pluck('value')->toArray())->select($modelname.'.*');

        foreach($this->config->index_scopes as $scope) {
            $model = $model->{$scope}();
        }

        $datatablesObject = DataTables::eloquent($model);

        foreach($mapper as $map) {
            $dataTablesObject = $datatablesObject->addColumn($map->value, function ($item) use ($map) {
                $key = $map->value;
                $field = $map->field;
                return $item->$key->$field;
            });
        }

        return $datatablesObject->toJson();
    }

    public function show($modelname, $id)
    {
        $this->setConfig($modelname);
        $model = $this->getModel($id);

        return view('admin.' . $modelname .'.show')
                    ->with('m', $model)
                    ->with('title', ucfirst(Str::singular($modelname)))
                    ->with('modelname', $modelname);
    }

    public function create(Request $request, $modelname)
	{
        $this->setConfig($modelname);
        $this->setReturnPathSessionVariable();

        if ($this->dealWithPrefillInputs($request)) {
            $parameters = $this->extractNonPrefillParameters($request);
            return redirect()->route('blueadmin.create', array_merge(['modelname' => $modelname], $parameters));
        }

        return view('BlueAdminPages::create')
        			->with('title', ucfirst(Str::singular($modelname)))
        			->with('modelname', $modelname);
	}

	public function store(Request $request, $modelname)
	{
        $this->setConfig($modelname);

        $valid = $request->validate( $this->config->validation() );

        // Make sure that boolean stuff is treated as boolean
        foreach (collect($this->config->fields)->where('type','boolean')->keys() as $key) {
            $valid[$key] = array_key_exists($key, $valid) ? true : false;
        }

        // Taking care of mediafiles - part 1
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                unset($valid[$file]);
            }
        }

        $model = $this->config->model::create($valid);

        // Taking care of mediafiles - part 2
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                $model->addMediaFromRequest($file)->toMediaCollection($file);
            }
        }

        $returnPath = Session::get('blueadmin.returnpath', route('blueadmin.index', $modelname) );
        return redirect($returnPath);
	}


    public function edit($modelname, $id)
    {
        $this->setConfig($modelname);
        $this->setReturnPathSessionVariable($id);

        $model = $this->getModel($id);

        return view('BlueAdminPages::edit')
        			->with('m', $model)
        			->with('title', ucfirst(Str::singular($modelname)))
        			->with('modelname', $modelname);
    }

    public function update(Request $request, $modelname, $id)
    {
    	$this->setConfig($modelname);
        $model = $this->getModel($id);

        $valid = $request->validate( $this->config->validation() );

        // Make sure that boolean stuff is treated as boolean
        foreach (collect($this->config->fields)->where('type','boolean')->keys() as $key) {
            $valid[$key] = array_key_exists($key, $valid) ? true : false;
        }

        // Taking care of mediafiles
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                optional($model->getFirstMedia($file))->delete();
                $model->addMediaFromRequest($file)->toMediaCollection($file);
                unset($valid[$file]);
            }
        }


        // Deal with special field types that require extra attention before saving
        /*
/*
        // Whenever a nullable field is empty, set value to null
        foreach($this->config->nullable_fields as $key) {
            $valid[$key] = ($valid[$key] == '') ? NULL : $valid[$key];
        }*/

        $model->update($valid);

        $returnPath = Session::get('blueadmin.returnpath', route('blueadmin.index', $modelname) );
        return redirect($returnPath);
    }


    public function destroy($modelname, $id)
    {
        $returnPath = str_replace(url('/'), '', url()->previous());
        $this->setConfig($modelname);
        $model = $this->getModel($id);

        $model->delete();
        return redirect($returnPath);
    }

    public function toggleShowDelete($modelname, Request $request)
    {
        $key = 'blueadmin-'.$modelname . '-index-show-delete';

        if ($request->session()->has($key)) {
            $request->session()->forget($key);
        } else {
            $request->session()->put($key, true);
        }

        return redirect()->back();
    }

    public function toggleOpenNewWindow($modelname, Request $request)
    {
        $key = 'blueadmin-'.$modelname . '-open-new-window';

        if ($request->session()->has($key)) {
            $request->session()->forget($key);
        } else {
            $request->session()->put($key, true);
        }

        return redirect()->back();
    }

    private function setConfig($modelname)
    {
        $CLASS = '\App\\BlueAdmin\\' . ucfirst( Str::singular($modelname));
        $this->modelname = $modelname;
        $this->config = new $CLASS;
    }

    private function getModel($id)
    {
        $model = $this->config->model::findOrFail($id);
        return $model;
    }

    private function setReturnPathSessionVariable($id = null)
    {
        $previousUrl = substr(url()->previous(),0, strpos(url()->previous(),'?')); // remove parameters

        if ( $id === null && route('blueadmin.create', $this->modelname) === $previousUrl)
            return;
        if ( $id !== null && route('blueadmin.edit', ['modelname' => $this->modelname, 'id' => $id]) === $previousUrl )
            return;

        Session::put('blueadmin.returnpath', str_replace(url('/'), '', url()->previous()));
    }


    private function dealWithPrefillInputs($request):bool
    {
        if($request->missing('prefill'))
            return false;

        Session::flash('prefill', $request->prefill);
        return true;
    }

    private function extractNonPrefillParameters($request):array
    {
        $parameters = $request->all();
        unset($parameters['prefill']);
        return $parameters;
    }
}
