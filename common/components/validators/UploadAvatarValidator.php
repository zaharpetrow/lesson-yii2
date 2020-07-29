<?php

namespace common\components\validators;

use yii\validators\Validator;

class UploadAvatarValidator extends Validator
{

    public $maxSize;
    public $mimeTypes;

    public function validateAttribute($model, $attribute)
    {
        
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $maxSize   = $this->maxSize;
        $mimeTypes = $this->json_encode($this->mimeTypes);
        return <<<JS
            var form = $('#upload-avatar');
            var fileInput = form.find('input[type="file"]')[0];
            var preview = $('div.preview-image img');
            var file = fileInput.files[0];

            $('.max-size').removeClass('error');
            $('.max-size').removeClass('success');
            $('.extensions').removeClass('error');
            $('.extensions').removeClass('success');
            $('.ratio').removeClass('warning');
            $('.ratio').removeClass('success');

            if (file.size > $maxSize) {
                $('.max-size').addClass('error');
            } else {
                $('.max-size').addClass('success');
            }

            if ($.inArray(file.type, $mimeTypes) === -1) {
                $('.extensions').addClass('error');
            } else {
                $('.extensions').addClass('success');
            }

            preview.ready(function () {
                if (preview.width() !== preview.height()) {
                    $('.ratio').addClass('warning');
                } else {
                    $('.ratio').addClass('success');
                }
            });
JS;
    }

    protected function json_encode($value)
    {
        return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}
