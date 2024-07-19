<div cat_id="{{$category['id']}}" id="sp_services_block_{{$category['id']}}" class="sp_services_block">
    @if($category->promo ?? null and $category->promo['flg_active'])
        <x-ui.modal custom-class="modal_promo_from_cat" id="cat_modal_id_{{$category['id']}}">
            <livewire:portal.components.service.modal-promo
                :promo="$category->promo"></livewire:portal.components.service.category-services>
        </x-ui.modal>
    @endif

    @if(count($groups) > 0)
        <h2>{{$category['name']}}</h2>
        @foreach($groups as $group)
            <div id="group_wrap_{{$group['id']}}" class="group_wrap">
                <div data-group-title="{{$group['id']}}" class="group_title_wrap">
                    <h2>{{$group['name']}}</h2>
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.46757 0.580322L7.50741 6.6202L13.5473 0.580322L14.7258 1.75883L7.50741 8.9772L0.289062 1.75883L1.46757 0.580322Z"
                            fill="#111010"/>
                    </svg>
                </div>


                <div id="services_in_group_{{$group['id']}}" class="sp_group_services_wrap">
                    @foreach($group->service as $service)
                        <div class="service_wrap">
                            <div class="info">
                                <a href="{{route('service_page', $service['id'])}}">
                                    <p class="duration"
                                       style="flex: none; width: 80px;">{{$service['yc_duration'] / 60}}
                                        мин</p>
                                </a>
                                <a href="{{route('service_page', $service['id'])}}">
                                    <p class="price" style="flex: none; width:110px;">
                                        @if($service['yc_price_min'] <> $service['yc_price_max'])
                                            от
                                        @endif
                                        {{number_format($service['yc_price_min'], 0, ',', ' ')}} ₽
                                    </p>
                                </a>
                                <a href="{{route('service_page', $service['id'])}}">
                                    <p>{{$service['name']}}</p>
                                </a>
                            </div>
                            <div class="buttons-wrap">
                                <livewire:portal.components.service.add-to-cart-button :service="$service"
                                                                                       type="link coal"></livewire:portal.components.service.add-to-cart-button>
                                <a href="{{route('service_page', $service['id'])}}"
                                   class="link fern">Подробнее</a>
                                <a class="svg_link" href="{{route('service_page', $service['id'])}}">
                                    <svg width="15" height="4" viewBox="0 0 15 4" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.833496 0.798828V3.29883H3.3335V0.798828H0.833496Z"
                                              fill="black"/>
                                        <path d="M6.25016 0.798828V3.29883H8.75016V0.798828H6.25016Z"
                                              fill="black"/>
                                        <path d="M11.6668 0.798828V3.29883H14.1668V0.798828H11.6668Z"
                                              fill="black"/>
                                    </svg>
                                </a>
                            </div>


                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach
    @endif
    @push('scripts')
            <script>
                modal_id = {{$category['id']}}
                // open_modal('sp_services_block_' + 1)
            </script>
    @endpush
</div>
