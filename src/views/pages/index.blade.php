@extends('adminlte::page')

@section('title', $title . ' | ' . config('app.name') . ' admin' )

@section('content_header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Site content
        <small>manage your website content</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('blueadmin.dashboard') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="">Site content</a></li>
        <li class="active">{{ $title }}</li>
      </ol>
    </section>

    
@stop

@section('content')

<section class="content">
      <div class="container-fluid">

		<div class="row">
          <div class="col-lg-8 col-sm-12">
            <div class="box">

              <div class="box-header">
                <h3 class="box-title">{{$title}}</h3>

                <div class="box-tools pull-right">

			        <div style="margin-top: 5px;">
    	                @if( app('request')->input('enable_delete') )
    	                    <a href="?" class="btn btn-xs text-muted"><i class="fas fa-toggle-on"></i>&nbsp;DELETE</a>&nbsp;&nbsp;&nbsp;
    	                @else
    	                    <a href="?enable_delete=true" class="btn btn-xs text-muted"><i class="fas fa-toggle-off"></i>&nbsp;DELETE</a>&nbsp;&nbsp;&nbsp;
    	                @endif
                    	
                    	<a href="{{route('blueadmin.create', ['modelname' => $modelname])}}" class="btn btn-xs btn-success"><i class="far fa-plus-square"></i>&nbsp;Create</a>
    	            </div>                


                </div>
              </div><!-- ./box-header -->

              <div class="box-body table-responsive p-0">
                <table class="table table-striped table-hover table-head-fixed">
                  <thead>
                    <tr>
                      @foreach($fields as $field => $value)
						            <th>{{ucfirst($field)}}</th>
                      @endforeach
						          <th width="135px">Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                  	@foreach($models as $m)
	                    <tr>
                        @foreach($fields as $field => $value)                        
  	                      <td>
                            @switch($value)
                              @case('boolean')
                                {!! ($m->$field) ? '<i class="far fa-check-circle text-success"></i>' : '<i class="far fa-times-circle text-danger"></i>' !!}
                                @break
                              @case('belongsto')
                                {{ optional($m->$field)->title ?? '-' }}
                                @break
                              @default
                                {{$m->$field ?? '-'}}
                                @break
                            @endswitch
  	                      </td>
                        @endforeach               
                        <td>           
	                      	<span class="pull-left" style="margin-left: 5px;">
	                      		<a href="{{ route('blueadmin.edit', ['modelname' => $modelname, 'id' => $m->id] )}}" class="btn btn-xs btn-primary pull-left"><i class="far fa-edit"></i>&nbsp;Edit</a>
	                      	</span>
            							@if( app('request')->input('enable_delete') )
            								<span class="pull-left" style="margin-left: 5px; margin-top: -1px;">
            									<form method="POST" action="{{ route('blueadmin.destroy', ['modelname' => $modelname, 'id' => $m->id]) }}">
            										@method('DELETE') @csrf
            										<button type="submit" class="btn btn-xs btn-warning"><i class="far fa-trash-alt"></i>&nbsp;Delete</button>
            									</form>
                            </span>&nbsp;
                          @endif
	                      </td>
	                    </tr>
                    @endforeach
                  </tbody>
                </table>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-12 col-md-2">

            @foreach($widgets as $widget)
              @widget($widget)
            @endforeach

          </div>


        </div>	


    </div>
</section>
@stop


@section('right-sidebar')
	@include('help.sitecontent')
@stop
