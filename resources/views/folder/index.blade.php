@extends('layout.main')

@section('main')
    <p>List Folder</p>
    <a href="{{ route('web.folder.create') }}">Create Folder</a>
    <div id="folder"></div>
@endsection

@push('js')
    $(() => {
        getFolder()
    })

    const getFolder = () => {
        let token = sessionStorage.getItem('token')

        $.ajax({
            url:`{{ env('APP_URL') }}/api/v1/folders`,
            dataType: 'JSON',
            headers: {
                'Authorization': 'Bearer ${token}'
            },
            success: function(response) {
                console.log(response)
            }
        })
    }
@endpush
