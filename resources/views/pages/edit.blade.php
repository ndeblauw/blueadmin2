@extends('adminlte::page')

@section('title', 'Edit ' . $title . ' ' . $m->id . ' | ' . config('app.name') . ' admin');


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
        <li class="active">Pages</li>
      </ol>
    </section>
@stop


@section('content')

<section class="content">
  <div class="container-fluid">

		<div class="row">
      <div class="col-lg-8">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="far fa-edit"></i>&nbsp;Edit {{$title}} <strong>{{$m->id}}</strong></h3>
            </div><!-- /.box-header -->

            <form role="form" action="{{ route('blueadmin.update', ['modelname' => $modelname, 'id' => $m->id]) }}" method="POST" class="horizontal" enctype="multipart/form-data">

              <div class="box-body">
                @csrf
                @method('PUT')

                @include('admin.' . $modelname .'._form')

              </div><!-- /.box-body -->

              <div class="box-footer" style="background-color: #dfe6ee">
                <div class="pull-right">
                  <a href="{{ Session::get('blueadmin.returnpath', route('blueadmin.index', $modelname) ) }}" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div><!-- /.box-footer -->
            
            </form>
          </div><!-- /.box -->

      </div>

    </div>	

  </div>
</section>
@stop


@section('right-sidebar')
	@includeFirst(['help.sitecontent', 'BlueAdminPages::genericHelp'])
@stop
