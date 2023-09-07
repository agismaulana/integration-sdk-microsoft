@extends('layout.main')

@section('main')

    <p>File List</p>
    <div id="file"></div>

@endsection

@push('js')
    <script>
        let token = sessionStorage.getItem('access_token')

        $.ajax({
            url: `{{ env('APP_URL') }}/api/v1/files`,
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(response) {
                console.log(response)
            }
        })
    </script>
@endpush
