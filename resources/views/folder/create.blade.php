@extends('layout.main')

@section('main')
    <p>Create Folder</p>
    <input type="text" name="name">
    <button id="create">Create folder</button>
@endsection

@push('js')
    $(() => {
        $('#create').on('click', function() {
            let token = sessionStorage.getItem('access_token');
            let name = $('input[name="name"]').val();

            $.ajax({
                url: `{{ env('APP_URL') }}/api/v1/folders/create`,
                data: {
                    'name': name,
                },
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response)
                }
            })
        })
    })
@endpush
