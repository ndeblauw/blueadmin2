@extends('BlueAdminLayouts::app', ['title' => ucfirst($modelname) . ' overview'])

@section('main')

<x-blueadmin-card :title="$title" :icon="$icon" col="col-12 col-md-12 col-lg-11" noPadding>

    <x-slot name="cardTools">
        @if( Session::get('blueadmin-'.$modelname . '-index-statesave') )
            <a href="{{route('blueadmin.index.toggle-statesave', ['modelname' => $modelname])}}" class="btn btn-xs text-success"><i class="fas fa-toggle-on"></i>&nbsp;STATE SAVE</a>
        @else
            <a href="{{route('blueadmin.index.toggle-statesave', ['modelname' => $modelname])}}" class="btn btn-xs text-muted"><i class="fas fa-toggle-off"></i>&nbsp;STATE SAVE</a>
        @endif


    @if( Session::get('blueadmin-'.$modelname . '-index-show-delete') )
            <a href="{{route('blueadmin.index.toggle-show-delete', ['modelname' => $modelname])}}" class="btn btn-xs text-success"><i class="fas fa-toggle-on"></i>&nbsp;SHOW DELETE</a>
        @else
            <a href="{{route('blueadmin.index.toggle-show-delete', ['modelname' => $modelname])}}" class="btn btn-xs text-muted"><i class="fas fa-toggle-off"></i>&nbsp;SHOW DELETE</a>
        @endif

        @if( Session::get('blueadmin-'.$modelname . '-open-new-window') )
            <a href="{{route('blueadmin.index.toggle-open-new-window', ['modelname' => $modelname])}}" class="btn btn-xs text-success"><i class="fas fa-toggle-on"></i>&nbsp;OPEN ACTIONS IN NEW WINDOW</a>&nbsp;&nbsp;&nbsp;
            @php $target = ' target=_blank '; @endphp
        @else
            <a href="{{route('blueadmin.index.toggle-open-new-window', ['modelname' => $modelname])}}" class="btn btn-xs text-muted"><i class="fas fa-toggle-off"></i>&nbsp;OPEN ACTIONS IN NEW WINDOW</a>&nbsp;&nbsp;&nbsp;
            @php $target = ' '; @endphp
        @endif

        @if(View::exists('admin.'.$modelname.'._form'))
            <a href="{{route('blueadmin.create', ['modelname' => $modelname])}}" class="btn btn-xs btn-success"><i class="far fa-plus-square"></i>&nbsp;Create</a>
        @endif
    </x-slot>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover table-head-fixed" id="{{$modelname}}-table" width="99%">
            <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column->title }}</th>
                @endforeach
                <th width="{{ ($modelname == 'users') ? '250px' : '185px' }}">Actions</th>
            </tr>
            </thead>
        </table>
    </div>

</x-blueadmin-card>

@if(View::exists('admin.'.$modelname.'._index-bottom'))
    @include('admin.'.$modelname.'._index-bottom')
@endif

@endsection


@if(View::exists('admin.'.$modelname.'._aside-index'))
@section('aside')
    @include('admin.'.$modelname.'._aside-index')
@endsection
@endif


@push('blueadmin_header')
    <!-- DataTables stuff -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .dataTables_filter {
            margin-top: 10px;
            margin-right: 10px;
        }

        .dataTables_length {
            margin-top: 10px;
            margin-left: 10px;
        }

        .dataTables_info {
            margin-bottom: 10px;
            margin-left: 10px;
        }

        .dataTables_paginate {
            margin-bottom: 10px;
            padding-right: 10px;
        }


    </style>
@endpush

<!-- DataTables -->
@push('blueadmin_scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
@endpush



@push('blueadmin_scripts')
<script>


$(function() {
    $('#{{$modelname}}-table').DataTable({
        @if( Session::has('blueadmin-'.$modelname . '-index-statesave') )
            stateSave: true,
        @endif
        processing: true,
        serverSide: true,
        ajax: '{!! route('blueadmin.api.index', $modelname) !!}',
        order: [{{ $initial_ordering['column'] }}, '{{ $initial_ordering['order'] }}'],
        columns: [
            @foreach($columns as $column)
                @switch($column->type)
                    @case('date')
                        { data: '{{ $column->value }}'},
                        @break
                    @case('belongsto')
                        { data: '{{ $column->value }}', name: '{{ $column->value }}.{{ $column->field }}' },
                        @break
                    @default
                        { data: '{{$column->value}}'},
                @endswitch
            @endforeach
        ],
        columnDefs: [
            @foreach($columns->where('type', 'sleeping') as $column_nr => $column)
            { targets: {{$column_nr}},
                render: function(data, type, row) {
                    if ( row['{{$column->value}}'] ) {
                        return '<i class="fad fa-snooze text-danger"></i>'
                    } else {
                        return ''
                    }
                }
            },
            @endforeach
        
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
                  actionfield = actionfield + '<span class="float-left" style="margin-left: 5px;"><a {{$target}} href="{{route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '" class="btn btn-xs btn-info"><i class="far fa-sticky-note"></i>&nbsp;Details</a>&nbsp;</span>'
                @endif

                @if($modelname == 'users')
                    actionfield = actionfield + '<span class="float-left" style="margin-left: 5px;"> <a href="/admin/users/' + row['id'] + '/loginas" class="btn btn-xs btn-warning pull-left"><i class="fas fa-sign-in-alt"></i>&nbsp;Login as</a></span>'
                @endif

                @if(View::exists('admin.'.$modelname.'._form'))
                  actionfield = actionfield + '<span class="float-left" style="margin-left: 5px;"> <a {{$target}} href="{{ route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '/edit" class="btn btn-xs btn-outline-primary pull-left"><i class="far fa-edit"></i>&nbsp;Edit</a></span>'
                @endif

                @if( Session::get('blueadmin-'.$modelname . '-index-show-delete') )
                  actionfield = actionfield + '<span class="float-left" style="margin-left: 5px; margin-top: -1px;"><form method="POST" action="{{ route('blueadmin.index', ['modelname' => $modelname]) }}/' + row['id'] + '"> @method('DELETE') @csrf <button type="submit" {!! config('blueadmin.confirm_delete') ? 'onclick="ConfirmDelete()"' : '' !!} class="btn btn-xs btn-outline-warning"><i class="far fa-trash-alt"></i>&nbsp;Delete</button></form></span>&nbsp;'
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

function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}

</script>
@endpush
