@extends('layout.main')

@push('css')

@endpush

@section('main')
    <p>Detail Group</p>
    <div id="detail"></div>
@endsection

@push('js')
    <script>
        $(() => {
            detailGroup()
        })

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
                    $(`#member`).html(html)
                }
            })
        }

        const detailGroup = () => {
            $.ajax({
                url: `${("{{ route('api.group.detail', ['groupId' => $id]) }}")}`,
                dataType: 'JSON',
                success: async (response) => {
                    const {id, displayName, description, mail} = response.data

                    let html = `
                        <h1>Display Name: ${displayName}</h1>
                        <p>description: ${description}</p>
                        <span>Mail: ${mail}</span>
                        <div id="member"></div>
                    `

                    await $('#detail').html(html)

                    await getMember(id)
                }
            })
        }
    </script>
@endpush
