<div class="modal" {{ $attributes }}>
    <div class="modal_wrap">
        <div class="modal_content">
            {{ $slot  }}
            <a class="close_modal_icon">
                <svg class="close_modal_icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.22364 18.3677L10.5876 12.0038L4.22363 5.63982L5.63785 4.22561L12.0018 10.5896L18.3657 4.22559L19.78 5.63981L13.416 12.0038L19.7799 18.3677L18.3657 19.782L12.0018 13.418L5.63785 19.7819L4.22364 18.3677Z"
                        fill="#DDDDD5" fill-opacity="0.3"/>
                </svg>
            </a>
        </div>
    </div>
</div>

