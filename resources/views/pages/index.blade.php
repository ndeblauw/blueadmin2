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
                <table class="table table-striped table-hover table-head-fixed" id="{{$modelname}}-table">
                  <thead>
                    <tr>
                      @foreach($columns as $column)
						            <th>{{ $column->title }}</th>
                      @endforeach
						          <th width="215px">Actions</th>
                    </tr>
                  </thead>
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

@section('blueadmin_header')
    <!-- DataTables stuff -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
@endsection

<!-- DataTables -->
@push('blueadmin_scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
@endpush



@push('blueadmin_scripts')
<script>
$(function() {
    $('#{{$modelname}}-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('blueadmin.api.index', $modelname) !!}',
        order: [{{ $initial_ordering['column'] }}, '{{ $initial_ordering['order'] }}'],
        columns: [
            @foreach($columns as $column)
              { data: '{{$column->value}}'},
            @endforeach
        ],
        columnDefs: [
            @foreach($columns->where('type', 'boolean') as $column_nr => $column)
            { targets: {{$column_nr}},
              render: function(data, type, row) {
                  if ( row['{{$column->value}}'] ) {
                    return '<i class="far fa-check-circle text-success"></i>'
                  } else {
                    return '<i class="far fa-times-circle text-danger"></i>'
                  }
              }
            },
            @endforeach
 
            { targets: {{$actions_col_nr}},
              render: function(data, type, row) {

                actionfield = '';
                @if(View::exists('admin.'.$modelname.'.show'))
                  actionfield = actionfield + '<span class="pull-left" style="margin-left: 5px;"><a href="{{route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '" class="btn btn-xs btn-info"><i class="far fa-sticky-note"></i>&nbsp;Details</a>&nbsp;</span>'
                @endif

                @if(View::exists('admin.'.$modelname.'._form'))
                  actionfield = actionfield + '<span class="pull-left" style="margin-left: 5px;"> <a href="{{ route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '/edit" class="btn btn-xs btn-primary pull-left"><i class="far fa-edit"></i>&nbsp;Edit</a></span>'
                @endif

                @if( app('request')->input('enable_delete') )
                  actionfield = actionfield + '<span class="pull-left" style="margin-left: 5px; margin-top: -1px;"><form method="POST" action="{{ route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '"> @method('DELETE') @csrf <button type="submit" class="btn btn-xs btn-warning"><i class="far fa-trash-alt"></i>&nbsp;Delete</button></form></span>&nbsp;'
                @endif

                return actionfield                
              }
            },

            { targets: [{{$actions_col_nr}}],
              searchable: false
            },
        ]
    });
});
</script>
@endpush



@section('right-sidebar')
	@includeFirst(['help.sitecontent', 'BlueAdminPages::genericHelp'])
@stop


