<div id="scopes_main_page" class="scopes_block">
<h1>все, что мы <br> делаем — красиво и с душой</h1>
<div class="scopes_wrap">
    @foreach($scopes as $scope)
        <div onclick="location.href='{{route('scope_page', $scope['id'])}}';" class="scope_wrap">
            <div class="image_blackout">
                <img src="{{$scope['pic_main_page']}}" alt="">
            </div>
            <div class="info">
                <h2>{{$scope['name']}}</h2>
                <div class="services_wrap">
                    <div class="services">
                        @foreach($scope->group as $group)
                                <p>{{$group['name']}}</p>
                        @endforeach
                    </div>
                    <a href="{{route('scope_page', $scope['id'])}}">
                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.03809 16.0424L13.078 10.0026L7.03809 3.96269L8.21659 2.78418L15.435 10.0026L8.21659 17.221L7.03809 16.0424Z" fill="#DDDDD5"/>
                            <path d="M15.0381 16.0424L21.078 10.0026L15.0381 3.96269L16.2166 2.78418L23.435 10.0026L16.2166 17.221L15.0381 16.0424Z" fill="#DDDDD5"/>
                        </svg>
                    </a>
                </div>


            </div>
        </div>
    @endforeach
</div>
</div>
