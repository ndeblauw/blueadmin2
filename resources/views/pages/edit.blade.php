@extends('BlueAdminLayouts::app', ['title' => ucfirst($modelname)])

@section('main')

    <form role="form" action="{{ route('blueadmin.update', ['modelname' => $modelname, 'id' => $m->id]) }}" method="POST" class="horizontal" enctype="multipart/form-data">

        <x-blueadmin-card :title="'Edit <strong>'.$title . '</strong> record ' . $m->id " icon="far fa-edit" col="col-12 col-md-7">

            @csrf
            @method('PUT')
            @include('admin.' . $modelname .'._form')

            <x-slot name="cardTools">
                <span class="font-weight-light">Fields with a <span class="text-primary">*</span> are required</span>
            </x-slot>

            <x-slot name="footer">
                <div class="float-right">
                    <a href="{{ Session::get('blueadmin.returnpath', route('blueadmin.index', $modelname) ) }}" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </x-slot>

        </x-blueadmin-card>

    </form>

@endsection
