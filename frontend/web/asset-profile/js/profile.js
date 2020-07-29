(function () {

    $('.delete-avatar').click(function (e) {
        if (!confirm("Удалить аватар?")) {
            e.preventDefault();
        }
    });

    $('.btn-primary').focus(function (e) {
        $(this).blur();
    });

    $('#update-avatar').on('click', function (e) {
        $('.window-alert').removeClass('hide');
    });

    var form = $('#upload-avatar');
    var fileInput = form.find('input[type="file"]')[0];
    var preview = $('div.preview-image img');

    form.on('afterValidate', function (e, attr, m) {
        var submit = $('#upload-avatar button[type=submit]');
        if (m.length > 0) {
            submit.addClass('disabled').attr('disabled', 'disabled');
        } else {
            submit.removeClass('disabled').removeAttr('disabled');
        }
    });

    var submit = $('#upload-avatar button[type="submit"]');
    var label = $('label.preview-image');
    var imgDataBlock = $('<div>', {class: 'img-data'});
    imgDataBlock.appendTo($(fileInput).parent());

    var circle = document.querySelector('.progress-ring__circle');
    var radius = circle.r.baseVal.value;
    var circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = circumference;

    function setProgress(percent) {
        var offset = circumference - percent / 100 * circumference;
        circle.style.strokeDashoffset = offset;
    }

    setProgress(0);

    form.on('submit', function (e) {
        e.preventDefault();
    });

    form.on('beforeValidate', function (e) {

        var $yiiform = $(this);
        var formData = new FormData(form[0]);
        $(circle).removeClass('op0');
        submit.addClass('disabled').attr('disabled', 'disabled');


        $.ajax({
            type: $yiiform.attr('method'),
            url: $yiiform.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var perecentComplete = Math.ceil(e.loaded / e.total * 100);

                        setProgress(perecentComplete);
//                        $('#progressbar').val(perecentComplete);
                    }
                }, false);
                return xhr;
            }
        }).done(function (data) {
            if (data.success) {
                setTimeout(function () {
                    $(circle).addClass('op0');
                    setTimeout(function () {
                        setProgress(0);
                        popupClose();
                        location.reload();
                    }, 350);
                }, 350);
                submit.removeClass('disabled').removeAttr('disabled');
                console.log('success');
            } else if (data.validation) {
                console.log(data.validation);
            } else {
                console.log('incorrect server response');
            }
        }).fail(function () {
            console.log('request failed');
        });

        return false;
    });

    form.on('change', 'input', function (e) {
        var file = this.files[0];
        var imgNameBlock = '<span>' + file.name + '</span>';
        var imgSizeBlock = '<span>' + (file.size / 1024 / 1024).toFixed(2) + ' МБ' + '</span>';
        var reader = new FileReader();

        reader.onload = (function (f) {

            return function (e) {
                preview.attr('src', e.target.result);
                preview.removeClass('width100');
                preview.removeClass('height100');

                preview.ready(function () {
                    if (preview.width() > preview.height()) {
                        preview.addClass('height100');
                    } else {
                        preview.addClass('width100');
                    }
                });
                preview.removeClass('hidden');
                label.addClass('change-image');
            };
        })(file);
        reader.readAsDataURL(file);

        imgDataBlock.html(imgNameBlock + ' - ' + imgSizeBlock);
    });

    $('.cancel').click(function (e) {
        var target = $(e.target);
        if (!$(target).hasClass('cancel')) {
            return;
        }
        popupClose();
    });

    function popupClose() {
        $('.window-alert').addClass('hide');
        preview.removeAttr('src');
        preview.addClass('hidden');
        submit.attr('disabled', 'disabled').addClass('disabled');
        label.removeClass('change-image');
        imgDataBlock.html('');
        form[0].reset();

        $('.max-size').removeClass('error');
        $('.max-size').removeClass('success');
        $('.extensions').removeClass('error');
        $('.extensions').removeClass('success');
        $('.ratio').removeClass('warning');
        $('.ratio').removeClass('success');
    }

}());

(function(){
    
    
    
}());