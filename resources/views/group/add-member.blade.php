@extends('layout.main')

@push('css')

@endpush

@section('main')
<h2>
    Add Member
</h2>
<form onsubmit="submitAdd(event)" method="POST">
    <div>
        <label for="">id</label>
        <input type="text" name="member_id">
        <button type="submit">
            submit
        </button>
    </div>
</form>
@endsection

@push('js')
    <script>
        const submitAdd = (e) => {
            e.preventDefault()
            let member = $('input[name="member_id"]').val()

            $.ajax({
                url: `${("{{ route('api.group.member.add', ['groupId' => $id]) }}")}`,
                data: {
                    member,
                },
                method: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    console.log(response)
                }
            })
        }
    </script>
@endpush
