@extends('layout.main')

@push('css')
    <style>
        .forward {
            display: flex;
            flex-direction: column;
            width: 50%;
        }
    </style>
@endpush

@section('main')

    <div class="forward">
        <label for="">Forward:</label>
        <input type="text" name="recipient">
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <button id="forward">Forward</button>
    </div>
    <div id="mail"></div>

@endsection

@push('js')
    <script>
        $(() => {
            getMail()
            $('#forward').on('click', () => {
                let comment = $('textarea[name="comment"]').val();
                let recipient = $('input[name="recipient"]').val();
                let data = {
                    comment,
                    toRecipient: recipient
                }
                forward(data);
            })
        })

        const forward = (data) => {
            let token = sessionStorage.getItem('access_token');

            $.ajax({
                url: `{{ env('APP_URL') }}/api/v1/mails/{{ $id }}/forward`,
                data: data,
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                dataType: 'JSON',
                method: 'POST',
                success: function(response) {
                    console.log(response)
                }
            })
        }

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
