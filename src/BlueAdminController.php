<?php

namespace Ndeblauw\BlueAdmin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BlueAdminController extends Controller
{
    protected $config;

    public function dashboard()
    {
        return view('BlueAdminPages::dashboard');
    }
    
    public function index($modelname)
    {
        $this->setConfig($modelname);

        $columns = $this->config->index_columns();

        if( isset($this->config->initial_ordering) )
        {
            if(! is_array($this->config->initial_ordering) ) {
                $initial_ordering = ['column' => $this->config->initial_ordering, 'order' => 'asc' ];
            } else {
                $initial_ordering = $this->config->initial_ordering;
            }
        } else {
            $initial_ordering = ['column' => 0, 'order' => 'asc'];
        }

        $actions_col_nr = $this->config->index_actions_column_nr();

        return view('BlueAdminPages::index')
        			->with('columns', $columns)
                    ->with('initial_ordering', $initial_ordering)
                    ->with('actions_col_nr', $actions_col_nr)
        			->with('title', ucfirst($modelname))
        			->with('modelname', $modelname)
                    ->with('widgets', $this->config->widgets() ?? []);
    }

    public function api_index($modelname)
    {
        $this->setConfig($modelname);
        $eager_load = $this->config->index_eager_load();

        return Datatables::of( $this->config->model::query()->with($eager_load) )->toJson();
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

    public function create($modelname)
	{
        Session::put('blueadmin.returnpath', str_replace(url('/'), '', url()->previous()) );

        $this->setConfig($modelname);

        return view('BlueAdminPages::create')
        			->with('title', ucfirst(Str::singular($modelname)))
        			->with('modelname', $modelname);
	}


    public function create_with_prefill($modelname, $prefill_modelname, $prefill_id)
    {
        Session::put('blueadmin.returnpath', str_replace(url('/'), '', url()->previous()) );

        $this->setConfig($prefill_modelname);
        $prefill = $this->getModel($prefill_id);

        $this->setConfig($modelname);

        return view('BlueAdminPages::create')
                    ->with('title', ucfirst(Str::singular($modelname)))
                    ->with('prefill', $prefill)
                    ->with('modelname', $modelname);
    }

	public function store(Request $request, $modelname) 
	{
        $this->setConfig($modelname);

        $valid = $request->validate( $this->config->validation() );
        foreach(array_keys($this->config->index_fields, 'boolean') as $key) {
            $valid[$key] = array_key_exists($key, $valid) ? 1 : 0;  
        }

        foreach($this->config->mediafiles() as $file) {
            unset($valid[$file]);
        }

        $model = $this->config->model::create($valid);

        foreach($this->config->mediafiles() as $file) {
            if($request->has($file)) {
                $model->addMediaFromRequest($file)->toMediaCollection($file);
            }
        }

        $returnPath = Session::get('blueadmin.returnpath', route('blueadmin.index', $modelname) );
        return redirect($returnPath);
	}


    public function edit($modelname, $id)
    {
        Session::put('blueadmin.returnpath', str_replace(url('/'), '', url()->previous()) );

        $this->setConfig($modelname);
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
		foreach(array_keys($this->config->index_fields, 'boolean') as $key) {
			$valid[$key] = array_key_exists($key, $valid) ? 1 : 0;	
		}
/*
        // Whenever a nullable field is empty, set value to null
        foreach($this->config->nullable_fields as $key) {
            $valid[$key] = ($valid[$key] == '') ? NULL : $valid[$key];
        }*/

        foreach($this->config->mediafiles() as $file) {
            if($request->has($file)) {
                optional($model->getFirstMedia($file))->delete();
                $model->addMediaFromRequest($file)->toMediaCollection($file);
                unset($valid[$file]);
            }
        }
        
        $model->update($valid);
        //$model->save();

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



    private function setConfig($modelname)
    {
        $CLASS = '\App\\BlueAdmin\\' . ucfirst( Str::singular($modelname));
        $this->config = new $CLASS;
    }

    private function getModels()
    {
        if( isset($this->config->index_orderby) && !is_array($this->config->index_orderby) ) {
            $this->config->index_orderby = ['variable' => $this->config->index_orderby, 'order' => 'ASC' ];
        }

        if(isset($this->config->index_orderby))
            $models = $this->config->model::orderBy($this->config->index_orderby['variable'], $this->config->index_orderby['order'])->get();
        else
            $models = $this->config->model::all();

        return $models;
    }

    private function getModel($id)
    {
        $model = $this->config->model::find($id);
        return $model;
    }


}
