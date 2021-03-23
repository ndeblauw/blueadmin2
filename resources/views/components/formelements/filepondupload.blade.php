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
                name="{{$name}}"
                id="{{ $id }}"
                value="{{old($id, $value)}}"
                class="filepond {{ ($errors->first($name) ? 'is-invalid' : '') }}"
                data-allow-reorder="true">
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>


@push('blueadmin_header')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush

@push('blueadmin_scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const inputElement = document.querySelector('.filepond');
        const pond = FilePond.create( inputElement );
        FilePond.setOptions({
            server: {
                url: '{{route('filepond.upload')}}',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
            },
        {{--
            files: [
                {
                    // the server file reference
                    source: '12345',

                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',

                        // mock file information
                        file: {
                            name: 'my-file.png',
                            size: 3001025,
                            type: 'image/png'
                        }
                    }
                }
            ]
            --}}

        });

    </script>
@endpush
