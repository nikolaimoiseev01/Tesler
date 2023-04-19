<div>
    <style>
        .cropped_preview {
            overflow: hidden;
            width: 200px;
            height: 200px;
        }
    </style>
    <form name="add-blog-post-form"
          method="post"
          class="p-5 mt-3"
          wire:submit.prevent="editgoodcategory(Object.fromEntries(new FormData($event.target)))">
        <div>
            <img id="image" src=" {{$src}}">
        </div>

        {{--        <div class="cropped_preview"></div>--}}
        <input style="display: none" id="min_width" value="{{$min_width}}" type="numer">
        <input style="display: none" id="min_height" value="{{$min_height}}" type="numer">

        <div style="display: none;" id="cropped_result"></div>

        <a id="save_crop" type="submit" class="w-100 mt-3 show_preloader_on_click btn btn-outline-primary">Сохранить</a>

    </form>


    <script>

        const image = document.getElementById('image');


        var minCroppedWidth = $('#min_width').val();
        var minCroppedHeight = $('#min_height').val();
        var maxCroppedWidth = 10000;
        var maxCroppedHeight = 10000;
        var cropper = new Cropper(image, {
            aspectRatio: $('#min_width').val() / $('#min_height').val(),
            viewMode: 2,
            dragMode: 'move',
            preview: '.cropped_preview',
            data: {
                width: (minCroppedWidth + maxCroppedWidth) / 2,
                height: (minCroppedHeight + maxCroppedHeight) / 2,
            },

            crop: function (event) {
                var width = Math.round(event.detail.width);
                var height = Math.round(event.detail.height);

                if (
                    width < minCroppedWidth
                    || height < minCroppedHeight
                    || width > maxCroppedWidth
                    || height > maxCroppedHeight
                ) {
                    cropper.setData({
                        width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
                        height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
                    });
                }
            },
            ready: function () {
                const cropper_el = this.cropper;
                $('#save_crop').click(function (e) {

                    e.preventDefault()
                    var croppedCanvas = cropper_el.getCroppedCanvas()

                    $('#crop_preview').fadeOut();
                    // Crop
                    // croppedCanvas = cropper.getCroppedCanvas();
                    var result = document.getElementById('cropped_result');
                    result.innerHTML = '';
                    result.appendChild(croppedCanvas);

                    croppedCanvas.toBlob(function (blob) {
                        var url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function () {
                        @this.set("cropped_img", reader.result);
                        @this.emit('save_crop');

                        }
                    });
                })


                $('#cancel_crop').click(function (e) {
                    e.preventDefault()
                    cropper_el.destroy();
                @this.set("file_preview", '');

                    $('#crop_preview').fadeOut();
                })

            }


        });


    </script>

    {{--    <script>--}}
    {{--        setTimeout(function() {--}}
    {{--            crop_init()--}}
    {{--        }, 1000)--}}

    {{--    </script>--}}


</div>
