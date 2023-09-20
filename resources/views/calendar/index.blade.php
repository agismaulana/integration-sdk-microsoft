@extends('layout.main')

@push('css')

@endpush

@section('main')
    <li>
        <mgt-agenda></mgt-agenda>
    </li>
@endsection

@push('js')
    <script type="text/javascript">
        $(() => {
            getCalendar();
        })

        function getCalendar() {
            $.ajax({
                url: `{{ route('api.calendars') }}`,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response)
                }
            })
        }
    </script>
@endpush
