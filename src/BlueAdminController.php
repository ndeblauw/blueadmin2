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
    private $filepond;

    public function __construct(Filepond $filepond)
    {
        $this->filepond = $filepond;
    }

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

        $mapperBelongsTo = $this->config->index_columns()->where('type', 'belongsto')->values();
        $mapperBelongsToMany = $this->config->index_columns()->where('type', 'belongsToMany')->values();

        $preloadRelations = array_merge($mapperBelongsTo->pluck('value')->toArray(), $mapperBelongsToMany->pluck('value')->toArray());
        $model = $this->config->model::with($preloadRelations)->select($modelname.'.*');

        $datatablesObject = DataTables::eloquent($model);

        foreach($mapperBelongsTo as $map) {
            $datatablesObject->addColumn($map->value, function ($item) use ($map) {
                $key = $map->value;
                $field = $map->field;
                return $item->$key->$field;
            });
        }

        foreach($mapperBelongsToMany as $map) {
            $datatablesObject->addColumn($map->value, function ($item) use ($map) {
                $key = $map->value;
                $field = $map->field;
                return $item->$key->pluck($field)->implode(', ');
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

        $valid = $request->validate( $this->config->parsed_validation() );

        // Make sure that boolean stuff is treated as boolean
        foreach (collect($this->config->fields)->where('type','boolean')->keys() as $key) {
            $valid[$key] = array_key_exists($key, $valid) ? true : false;
        }

        // Make sure that belongsToMany stuff is treated correctly - part 1
        $belongsToMany = [];
        foreach (collect($this->config->fields)->where('type','belongsToMany')->keys() as $key) {
            if (array_key_exists($key, $valid)) {
                $belongsToMany[$key] = $valid[$key];
                unset($valid[$key]);
            }
        }

        // Taking care of mediafiles through filepond
        foreach (collect($this->config->fields)->where('type','filepond')->keys() as $key)
        {
            $data = is_array($valid[$key]) ? $valid[$key] : [$valid[$key]];
            foreach($data as $item) {
                ray($item);
                ray($this->filepond->getPathFromServerId($item));
            }

            dd('stop');
        }

        // Taking care of mediafiles - part 1
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                unset($valid[$file]);
            }
        }

        // Taking care of files - part 1
        foreach (collect($this->config->fields)->where('type','file')->keys() as $file) {
            if($request->has($file)) {
                unset($valid[$file]);
            }
        }

        $model = $this->config->model::create($valid);

        // Make sure that belongsToMany stuff is treated correctly - part 2
        foreach ($belongsToMany as $key => $value) {
            $model->$key()->sync($value);
        }

        // Taking care of mediafiles - part 2
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                $model->addMediaFromRequest($file)->toMediaCollection($file);
            }
        }

        // Taking care of file uploads - part 2
        foreach (collect($this->config->fields)->where('type','file')->keys() as $file) {
            if($request->has($file)) {
                $f_orig = $this->config->fields[$file]['filename_original'];
                $f_disk = $this->config->fields[$file]['disk'];
                $f = $request->file($file);
                $model->$f_orig = $f->getClientOriginalName();
                $path = $f->store(null,$f_disk);
                $model->$file = $path;
                $model->save();
            }
        }

        switch($this->config->afterCreate()) {
            case 'back':
                $returnPath = Session::get('blueadmin.returnpath', route('blueadmin.index', ['modelname' => $modelname]) );
                return redirect($returnPath);

            case 'index':
                return redirect()->route('blueadmin.index', ['modelname' => $modelname]);

            case 'show':
                return redirect()->route('blueadmin.show', ['modelname' => $modelname, 'id' => $model->id]);
        }
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

        $valid = $request->validate( $this->config->parsed_validation($model) );

        // Make sure that boolean stuff is treated as boolean
        foreach (collect($this->config->fields)->where('type','boolean')->keys() as $key) {
            $valid[$key] = array_key_exists($key, $valid) ? [false, true][$valid[$key]] : false;
        }

        // Make sure that belongsToMany stuff is treated correctly
        foreach (collect($this->config->fields)->where('type','belongsToMany')->keys() as $key) {
            if (array_key_exists($key, $valid)) {
                $model->$key()->sync($valid[$key]);
                unset($valid[$key]);
            } else {
                $model->$key()->sync([]);
            }
        }

        // Taking care of mediafiles
        foreach (collect($this->config->fields)->where('type','mediafile')->keys() as $file) {
            if($request->has($file)) {
                optional($model->getFirstMedia($file))->delete();
                $model->addMediaFromRequest($file)->toMediaCollection($file);
                unset($valid[$file]);
            }
        }

        // Taking care of file uploads
        foreach (collect($this->config->fields)->where('type','file')->keys() as $file) {
            if($request->has($file)) {
                $f_orig = $this->config->fields[$file]['filename_original'];
                $f_disk = $this->config->fields[$file]['disk'];
                $f = $request->file($file);
                $model->$f_orig = $f->getClientOriginalName();
                $path = $f->store(null,$f_disk);
                $model->$file = $path;
                $model->save();
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

        switch($this->config->afterEdit()) {
            case 'back':
                $returnPath = Session::get('blueadmin.returnpath', route('blueadmin.index', ['modelname' => $modelname]) );
                return redirect($returnPath);

            case 'index':
                return redirect()->route('blueadmin.index', ['modelname' => $modelname]);

            case 'show':
                return redirect()->route('blueadmin.show', ['modelname' => $modelname, 'id' => $model->id]);
        }
    }


    public function destroy($modelname, $id)
    {
        $returnPath = str_replace(url('/'), '', url()->previous());
        $this->setConfig($modelname);
        $model = $this->getModel($id);

        $model->delete();
        return redirect($returnPath);
    }

    public function toggleStatesave($modelname, Request $request)
    {
        $key = 'blueadmin-'.$modelname . '-index-statesave';

        if ($request->session()->has($key)) {
            $request->session()->forget($key);
        } else {
            $request->session()->put($key, true);
        }

        return redirect()->back();
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
        // remove get parameters, if any
        $previousUrl = substr(
            url()->previous(),
            0,
            strpos(url()->previous(),'?') ?: strlen(url()->previous())
        );

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
