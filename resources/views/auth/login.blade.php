@extends('layout.main')

@section('main')
    <input type="text" name="email">
    <input type="password" name="password">
    <button id="login">Login</button>
@endsection

@push('js')
    <script>
        $(() => {
            $('#login').on('click', function() {
                $.ajax({
                    url: `{{ env('APP_URL') }}/login`,
                    // url: `{{ env('APP_URL') }}/api/v1/auth/authorize`,
                    data: {
                        '_token': `{{ csrf_token() }}`,
                        'email': $('input[name="email"]').val(),
                        'password': $('input[name="password"]').val()
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(response) {
                        sessionStorage.setItem('access_token', response.data.access_token);
                    }
                })
            })
        })
    </script>
@endpush
