<div>
    <style>
        table a {
            color: #007bff !important;
            text-decoration: none;
            background-color: transparent;
        }
    </style>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 10px">ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Курс</th>
            <th>Комментарий</th>
            <th>Создан</th>
            <th>Обновлен</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach($CourseApps as $CourseApp)
            <tr>
                <td>{{$CourseApp['id']}}</td>
                <td>{{$CourseApp['user_name']}}</td>
                <td>{{$CourseApp['user_mobile']}}</td>
                <td><a href="{{route('course.edit', $CourseApp->course['id'])}}">{{$CourseApp->course['title']}}</a></td>
                <td>{{$CourseApp['user_comment']}}</td>
                <td>{{date('d-m-Y H:i', strtotime($CourseApp['created_at']))}}</td>
                <td>{{date('d-m-Y H:i', strtotime($CourseApp['updated_at']))}}</td>
                <td>
                    <div class="form-group">
                        <select id="{{$CourseApp['id']}}" class="form-control">
                            @foreach($consult_statuses as $consult_status)
                                <option
                                    @if($CourseApp['consult_status_id'] == $consult_status['id']) selected
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
            @this.emit('update_CourseApp', $(this).attr('id'), $(this).val());

            })
        </script>
    @endpush

</div>
