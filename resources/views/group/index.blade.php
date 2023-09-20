@extends('layout.main')

@push('css')

@endpush

@section('main')
    <p>Group</p>
    <a href="{{ route('web.groups.create') }}">Create Groups</a>
    <div class="group"></div>
@endsection

@push('js')
    <script>
        $(() => {
            getGroup()
        })

        const getGroup = () => {
            $.ajax({
                url: `{{ route('api.group.index') }}`,
                dataType: 'JSON',
                success: async function(response) {
                    let html = ''
                    let member = [];
                    if(response.data.value.length === 0)
                        html = '-';

                    $.each(response.data.value, (key, value) => {
                        member.push(getMember(value.id));
                    })

                    $.each(response.data.value, (key, value) => {
                        html += `
                            <h2>${value.displayName} - ${value.id}</h2>
                            <a href="${("{{ route('web.groups.detail', ['groupId' => 'id']) }}").replace('id', value.id)}">detail</a>
                            <a href="${("{{ route('web.groups.add', ['groupId' => 'id']) }}").replace('id', value.id)}">Tambah</a>
                            <a href="${("{{ route('web.groups.edit', ['groupId' => 'id']) }}").replace('id', value.id)}">edit</a>
                            <button href="#" onclick="deleteGroup('${value.id}')" data-id="${value.id}">delete</button>
                            <div class="member-${value.id}">
                            </div>
                        `
                    })

                    $('.group').html(html)
                }
            })
        }

        const getMember = (id) => {
            let member = [];
            $.ajax({
                url: (`{{ route('api.group.member', 'id') }}`).replace('id', id),
                dataType: 'JSON',
                success: function(response) {
                    let html = '';
                    if(response.data.value.length === 0)
                        html = '-';

                    $.each(response.data.value, (key, value) => {
                        html += `
                            <p>
                                ${value.id} - ${value.displayName}
                            <p>
                        `
                    })
                    $(`.member-${id}`).html(html)
                }
            })
        }

        const deleteGroup = (id) => {
            console.log(`id on delete function: ${id}`)
        }
    </script>
@endpush
