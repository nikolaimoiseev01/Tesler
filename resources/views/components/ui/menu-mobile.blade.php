<div x-data="{ open: false }" class="menu_mobile_wrap" id="menuToggle">
    <svg @click.prevent="open = true" width="18" height="12" viewBox="0 0 18 12" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path d="M18 5H0V7H18V5Z" fill="#E3E396"/>
        <path d="M18 0H0V2H18V0Z" fill="#E3E396"/>
        <path d="M18 10H0V12H18V10Z" fill="#E3E396"/>
    </svg>

    <div :class="{ 'active': open }" class="menu_mobile">
        <div class="title_wrap">
            <h2>МЕНЮ</h2>
            <svg @click.prevent="open = false" width="16" height="16" viewBox="0 0 16 16" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0.118418 14.3638L6.48238 7.99988L0.118408 1.63591L1.53263 0.2217L7.89658 6.58568L14.2605 0.22168L15.6748 1.6359L9.31078 7.99988L15.6747 14.3638L14.2605 15.7781L7.89658 9.41408L1.53263 15.778L0.118418 14.3638Z"
                    fill="#DDDDD5" fill-opacity="0.3"/>
            </svg>
        </div>

        <div class="links_wrap">
            <div>
                <a href="{{route('home')}}" class="link"> Главная </a>
            </div>
            <div class="scopes">
                <div class="scopes_title_wrap">
                    <p class="link"> Услуги и прайс </p>
                    <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.65567 0.837891L8.90348 8.08574L16.1514 0.837891L17.5656 2.2521L8.90348 10.9141L0.241455 2.2521L1.65567 0.837891Z"
                            fill="#DDDDD5"/>
                    </svg>
                </div>

                <div id="scopes_links_wrap">
                    <div class="scopes_links_wrap">
                        @foreach($scopes_menu_mobile as $scope)
                            <a href="{{route('scope_page', $scope['id'])}}" class="link"> {{$scope['name']}} </a>
                        @endforeach
                    </div>
                </div>
                @push('scripts')
                    <script>
                        $('.scopes_title_wrap').on('click', function () {
                            console.log('test');
                            $('#scopes_links_wrap').slideToggle();
                        })
                    </script>
                @endpush
            </div>

            <div>
                <a href="{{route('market_page')}}" class="link"> Магазин </a>
            </div>
            <div>
                <a href="{{route('abonements_page')}}" class="link"> Абонементы и сертификаты </a>
            </div>
            <div>
                <a href="{{route('loyalty_page')}}" class="link"> Программа лояльности </a>
            </div>
            <div>
                <a href="{{route('home')}}#footer" class="link"> Контакты </a>
            </div>

            <div class="info">
                <p>09:00</p>
                <p>Красноярск, ул. Авиаторов, д. 21</p>
                <p>+7 988 777 56-67</p>
            </div>

            <a target="_blank" href="https://b253254.yclients.com/company/247576/record-type?o=" class="link-bg fern">
                ЗАПИСАТЬСЯ
            </a>
        </div>

    </div>
</div>
