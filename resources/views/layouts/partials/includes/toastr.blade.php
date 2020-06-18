@if(session()-> has('toastr'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }

        @if(!is_array(Session::get('toastr')))
        toastr.info("{{ Session::get('toastr') }}");
            @else

        var type = "{{ Session::get('toastr')['type'] }}";
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('toastr')['message'] }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('toastr')['message'] }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('toastr')['message'] }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('toastr')['message'] }}");
                break;
        }
        @endif
        @endif

    </script>
