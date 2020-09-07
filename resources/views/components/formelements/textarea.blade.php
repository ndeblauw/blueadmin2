<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            rows="6"
            placeholder="{{ $placeholder }}"
            class="form-control form-control {{ ($errors->first($name) ? "is-invalid" : "") }}"
            {{$disabled}}
        >{{ old($name, $value) }}</textarea>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>

@if($rte)
    @push('blueadmin_scripts')
        <script src="/lteadmin/vendor/tinymce/tinymce.min.js"></script>
        <script>
            var editor_config = {
                path_absolute: "{{ URL::to('/') }}/",
                selector:'#{{ $id }}',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks fullscreen',
                    'contextmenu paste help wordcount code'
                ],
                toolbar: ' undo redo |  bold italic | link | alignleft aligncenter alignright alignjustify | outdent indent | removeformat | code | help',
            }
            tinymce.init(editor_config);
        </script>
    @endpush
@endif
