@extends('BlueAdminLayouts::app', ['title' => ucfirst($modelname)])

@section('main')

    <form role="form" action="{{ route('blueadmin.store', ['modelname' => $modelname]) }}" method="POST" class="horizontal" enctype="multipart/form-data">

        <x-blueadmin-card :title="'Create new <strong>'.$title . '</strong> record'" icon="far fa-plus-square" col="col-12 col-md-7">

            @csrf
            @include('admin.' . $modelname .'._form', ['ba_form_create' => true])

            <x-slot name="cardTools">
                <span class="font-weight-light">Fields with a <span class="text-primary">*</span> are required</span>
            </x-slot>

            <x-slot name="footer">
                <div class="float-right">
                    <a href="{{ route('blueadmin.index', ['modelname' => $modelname]) }}" class="btn btn-default">Cancel</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </x-slot>

        </x-blueadmin-card>

    </form>

@endsection
