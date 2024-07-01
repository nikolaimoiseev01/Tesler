<div class="content sp_faq faq_wrap">
    <p class="title">ПОПУЛЯРНЫЕ ВОПРОСЫ</p>
    <div class="questions_wrap">

        <div class="column">
            @for($i = 0; $i < $halfCount; $i++)
                <div class="question_wrap">
                    <p data-q-id="{{$i}}" class="question">
                        {{ $questions[$i]['question'] }}
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                fill="#111010"/>
                        </svg>
                    </p>
                    <div style="display: none;" id="a_{{$i}}" class="answer">
                        <p>{{ $questions[$i]['answer'] }}</p>
                    </div>
                </div>
            @endfor
        </div>
        <div class="column">
            @for($i = $halfCount; $i < count($questions); $i++)
                <div class="question_wrap">
                    <p data-q-id="{{$i}}" class="question">
                        {{ $questions[$i]['question'] }}
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.76948 0.00390625V8.00381H0.769531V10.0038H8.76948V18.0039H10.7695V10.0038H18.7695V8.00381H10.7695V0.00390625H8.76948Z"
                                fill="#111010"/>
                        </svg>
                    </p>
                    <div style="display: none;" id="a_{{$i}}" class="answer">
                        <p>{{ $questions[$i]['answer'] }}</p>
                    </div>
                </div>
            @endfor
        </div>



    </div>

</div>
