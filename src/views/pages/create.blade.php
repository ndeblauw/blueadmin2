@extends('adminlte::page')

@section('title', 'New ' . $title . ' | ' . config('app.name') . ' admin')

@section('content_header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Site content
        <small>manage your website content</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
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
              <h3 class="box-title"><i class="far fa-plus-square"></i>&nbsp;Add a new <strong>{{$title}}</strong></h3>
            </div><!-- /.box-header -->

            <form role="form" action="{{ route('blueadmin.store', ['modelname' => $modelname]) }}" method="POST" class="horizontal">

              <div class="box-body">
                @csrf


                @include('admin.' . $modelname .'._form')

              </div><!-- /.box-body -->

              <div class="box-footer" style="background-color: #dfe6ee">
                <div class="pull-right">
                  <a href="{{ route('blueadmin.index', ['modelname' => $modelname]) }}" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary">Add</button>
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
	@include('help.sitecontent')
@stop
