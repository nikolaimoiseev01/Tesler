<div>
    <button type="submit" wire:click.prevent="search_for_staffs()"
            class="mb-3  show_preloader_on_click btn btn-outline-primary">
        Обновить сотрудников
    </button>

    <button type="submit" wire:click.prevent="refresh_staff_yc_info()"
            class="mb-3  show_preloader_on_click btn btn-outline-primary">
        Обновить YC инфо
    </button>



    @if ($found_yc_staffs)
        <style>
            td {
                vertical-align: inherit !important;
            }
        </style>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Нашли следующие новые товары:</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: fit-content"></th>
                        <th style="width: 10px">YC_ID</th>
                        <th>Имя</th>
                        <th>Аватар</th>
                        <th>Позиция</th>
                        <th>Специализация</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($found_yc_staffs as $found_yc_staff)
                        <tr>

                            <td>{{ $loop->index }}</td>
                            <td>{{$found_yc_staff['yc_id']}}</td>
                            <td>{{$found_yc_staff['yc_name']}}</td>
                            <td><img style="border-radius: 50%; max-width: 50px;" src="{{$found_yc_staff['yc_avatar']}}" alt=""></td>
                            <td>{{$found_yc_staff['yc_position']}}</td>
                            <td>{{$found_yc_staff['yc_specialization']}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <button type="submit" wire:click="add_found_staffs()"
                        class="mt-3 show_preloader_on_click btn btn-outline-primary">
                    Добавить в систему
                </button>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <livewire:admin.staff.staff-table/>
        </div>
    </div>
</div>
