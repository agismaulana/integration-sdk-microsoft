@extends('layout.main')

@push('css')
    <style>
        .form {
            display: flex;
            flex-direction: column;
            width: 50%;
        }
    </style>
@endpush

@section('main')
    <p>Create Mail</p>
    <div class="form">
        <div>
            <label for="">to:</label>
            <input type="text" name="toRecipient" id="recipient" placeholder="recipients....">
        </div>
        <div>
            <label for="">cc:</label>
            <input type="text" name="ccRecipient" id="recipient" placeholder="recipients....">
        </div>
        <div>
            <label for="">Subject:</label>
            <input type="text" name="subject" id="subject" placeholder="subject.....">
        </div>
        <textarea name="content" id="content" cols="30" rows="10" placeholder="content....."></textarea>
        <button id="create">Create Mail</button>
    </div>

@endsection

@push('js')
    <script>
        let token = sessionStorage.getItem('access_token')
        $(() => {
            $('#create').on('click', () => {
                let toRecipient = $('input[name="toRecipient"]').val();
                let ccRecipient = $('input[name="ccRecipient"]').val();
                let subject = $('input[name="subject"]').val();
                let content = $('textarea[name="content"]').val();

                $.ajax({
                    url: `{{ env('APP_URL') }}/api/v1/mails/send`,
                    data: {
                        toRecipient,
                        ccRecipient,
                        subject,
                        content
                    },
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(response) {
                        console.log(response)
                    }
                })
            })
        })
    </script>
@endpush
