@extends('layout.main')

@push('css')

@endpush

@section('main')
    <p>
        Mailbox Settings
    </p>
@endsection

@push('js')
    <script>
        $(() => {
            getMailBox()
        })

        const getMailBox = () => {
            $.ajax({
                url: `{{ route('api.mails.mailbox.check') }}`,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response)
                }
            })
        }
    </script>
@endpush
