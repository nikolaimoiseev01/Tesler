<div>
    <a wire:click.prevent="send_whatsapp" class="button">Отправить WhatsApp</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 10px">ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Комментарий</th>
            <th>Создан</th>
            <th>Обновлен</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach($consultations as $consultation)
            <tr>
                <td>{{$consultation['id']}}</td>
                <td>{{$consultation['user_name']}}</td>
                <td>{{$consultation['user_mobile']}}</td>
                <td>{{$consultation['user_comment']}}</td>
                <td>{{date('d-m-Y H:i', strtotime($consultation['created_at']))}}</td>
                <td>{{date('d-m-Y H:i', strtotime($consultation['updated_at']))}}</td>
                <td>
                    <div class="form-group">
                        <select id="{{$consultation['id']}}" class="form-control">
                            @foreach($consult_statuses as $consult_status)
                                <option
                                    @if($consultation['consult_status_id'] == $consult_status['id']) selected
                                    @endif value="{{$consult_status['id']}}">{{$consult_status['title']}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @push('scripts')
        <script>
            $('select').on('change', function () {
                console.log($(this).attr('id'), $(this).val())
            @this.emit('update_consultation', $(this).attr('id'), $(this).val());

            })
        </script>
    @endpush

</div>
