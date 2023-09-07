@extends('layout.main')

@push('css')
    <style>
        .mail-card {
            display: block;
            width: 100%;
            max-height: 320px;
            border: 1px solid black;
            box-sizing: border-box;
            padding: 20px;
            text-decoration: none;
            color: black;
        }
    </style>
@endpush

@section('main')

<a href="{{ route('web.email.create') }}">Create Email</a>
<br>
<div id="mail"></div>

@endsection

@push('js')
    <script>
        $(() => {
            getMail();
        });

        function getMail() {
            let token = sessionStorage.getItem('access_token');

            $.ajax({
                url: `{{ env('APP_URL') }}/api/v1/mails`,
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: function(response) {
                    let html = '';
                    $.each(response.value, (key, mail) => {
                        let route = `{{ route('web.email.show', ['id' => 'id']) }}`
                        route = route.replace('id', mail.id);
                        html += `
                            <a href="${route}" class="mail-card">
                                <div>
                                    <h3>${mail.sender ? mail.sender.emailAddress.name : ''}</h3>
                                    <span>${mail.sender ? mail.sender.emailAddress.address : ''}</span>
                                    <p>${mail.bodyPreview}</p>
                                </div>
                            </a>
                        `
                    })
                    $('#mail').html(html)
                }
            })
        }
    </script>
@endpush
