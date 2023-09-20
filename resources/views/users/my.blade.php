@extends('layout.main')

@push('css')

@endpush

@section('main')
    <div id="container"></div>
@endsection

@push('js')
    <script>
        $(() => {
            getProfile()
            licenseDetail()
            organize()
            mailbox()
        })

        const getProfile = () => {
            $.ajax({
                url: `{{ route('api.users.my') }}`,
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    console.log('profile: '+response)
                }
            })
        }

        const licenseDetail = () => {
            $.ajax({
                url: `{{ route('api.users.license') }}`,
                method: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    console.log('license: '+response)
                }
            })
        }

        const organize = () => {
            $.ajax({
                url: `{{ route('api.users.organization') }}`,
                method: "GET",
                dataType: 'JSON',
                success: (response) => {
                    console.log('organize: '+response)
                }
            })
        }

        const mailbox = () => {
            $.ajax({
                url: `{{ route('api.users.mailboxSettings') }}`,
                method: "GET",
                dataType: 'JSON',
                success: (response) => {
                    console.log('mailbox: '+response)
                }
            })
        }
    </script>
@endpush
