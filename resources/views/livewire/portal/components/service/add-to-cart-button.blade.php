<div>
    <a target="_blank"
       wire:click="$dispatch('service_cart_add', { service_id: {{$service['id']}} })"
       id="service_add_bg_{{$service['id']}}"
       class="link-bg coal">Записаться</a>
</div>
