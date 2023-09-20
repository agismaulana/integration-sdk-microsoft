@extends('layout.main')

@push('css')

@endpush

@section('main')
    <p>Create new Group</p>
    <form action="#" onsubmit="createGroup(event)" method="POST">
        <div>
            <label for="">Description</label>
            <input type="text" name="description">
        </div>
        <div>
            <label for="">Display Name</label>
            <input type="text" name="display_name">
        </div>
        <div>
            <label for="">Mail Nickname</label>
            <input type="text" name="mail_nickname">
        </div>
        <div>
            <label for="">Group Types</label>
            <textarea name="group_types" id="" cols="30" rows="10"></textarea>
        </div>
        <div>
            <input type="checkbox" name="mail_enabled"> Mail Enabled
            <input type="checkbox" name="security_enabled"> Security Enabled
        </div>
        <button type="submit">submit</button>
    </form>
@endsection

@push('js')
    <script>
        $(() => {

        })

        const createGroup = (e) => {
            e.preventDefault()

            const data = {
                description: $('input[name="description"]').val(),
                display_name: $('input[name="display_name"]').val(),
                mail_nickname: $('input[name="mail_nickname"]').val(),
                group_types: $('textarea[name="group_types"]').val(),
                mail_enabled: $('input[name="mail_enabled"]').val(),
                security_enabled: $('input[name="security_enabled"]').val(),
            }

            $.ajax({
                url: `{{ route('api.group.add') }}`,
                method: 'POST',
                dataType: 'JSON',
                data,
                success: function(response) {
                    console.log(response)
                }
            })
        }
    </script>
@endpush
