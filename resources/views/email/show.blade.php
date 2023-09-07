@extends('layout.main')

@push('css')
    <style>

    </style>
@endpush

@section('main')

    <div id="mail"></div>
    <a href="{{ route('web.email.forward', ['id' => $id]) }}">Forward</a>

@endsection

@push('js')
    <script>
        $(() => {
            getMail()
        })

        const getMail = () => {
            let token = sessionStorage.getItem('access_token');

            $.ajax({
                url: `{{ env('APP_URL') }}/api/v1/mails/{{ $id }}`,
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(response) {
                    let mail = response;

                    let html = `
                        <div>
                            <h3>${mail.sender ? mail.sender.emailAddress.name : ''}</h3>
                            <span>${mail.sender ? mail.sender.emailAddress.address : ''}</span>
                            <p>to: ${mail.toRecipients.map((val) => {
                                return `${val.emailAddress.address}`
                            })}</p>
                            <p>cc: ${mail.ccRecipients.map((val) => {
                                return `${val.emailAddress.address}`
                            })}</p>
                            ${mail.body.content}
                        </div>
                    `
                    $('#mail').html(html)
                }
            })
        }
    </script>
@endpush
