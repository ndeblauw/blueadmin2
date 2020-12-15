<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>

        @if( isset($model) && ($model->$name !== null) )
            <div class="row">
                <div class="col-4">
                    <a href="">{{ $model->filename_original }}</a>
                </div>
                <div class="col-8">
                    <span class="text-muted">Uploading a new {{$name}} will automatically remove this file.</span>
                </div>
            </div>
        @endif

        <input
                type="file"
                name="{{$id}}"
                id="{{ $id }}"
                value="{{old($id, $value)}}"
                class="form-control {{ ($errors->first($name) ? 'is-invalid' : '') }}"
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
