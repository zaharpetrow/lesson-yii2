$(function () {
    $(".btn").click(function () {
        (new Sign()).toggleForm(this);
    });

    function Sign() {
        this.activeBtn = $('.sign-active');
        this.inactiveBtn = $('.sign:not(.sign-active)');
        this.signinForm = $('form.form-signin');
        this.signupForm = $('form.form-signup');
        this.forgot = $('.forgot');
        this.frame = $('.frame');
        this.classes = {
            signinLeft: 'form-signin-left',
            signupLeft: 'form-signup-left',
            forgotLeft: 'forgot-left',
            frameLong: 'frame-long'
        };
        this.toggleBtn = function (btn) {
            if ($(btn).hasClass('active')) {
                return false;
            }

            var active = this.activeBtn;

            this.activeBtn = this.inactiveBtn;
            this.inactiveBtn = active;

            this.activeBtn
                    .addClass('sign-active')
                    .children('.btn')
                    .addClass('active');
            this.inactiveBtn
                    .removeClass('sign-active')
                    .children('.btn')
                    .removeClass('active');

            return true;
        };
        this.toggleForm = function (btn) {
            if (!this.toggleBtn(btn)) {
                return;
            }

            this.signinForm.toggleClass(this.classes.signinLeft);
            this.signupForm.toggleClass(this.classes.signupLeft);
            this.forgot.toggleClass(this.classes.forgotLeft);
            this.frame.toggleClass(this.classes.frameLong);
        };
    }

});

$(function () {
    $("form.form-signup").on('beforeValidate', function () {
        var $yiiform = $(this);
        $.ajax({
            type: $yiiform.attr('method'),
            url: $yiiform.attr('action'),
            data: $yiiform.serializeArray()
        }).done(function (data) {
            console.log(data);
            if (data.success) {
//                data is saved
                signupSuccess();
            } else if (data.validation) {
//                server validation failed
                $yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
//                incorrect server response
                console.log('incorrect server response');
            }
        }).fail(function () {
//            request failed
        });

        function signupSuccess() {
            $(".nav").toggleClass("nav-up");
            $(".form-signup-left").toggleClass("form-signup-down");
            $(".success").toggleClass("success-left");
            $("#check").addClass('checked');
//          $(".frame").toggleClass("frame-short");
            $(".btn-goback").toggleClass("btn-goback-signup");
        }

        return false;
    });
});

$(function () {
    $("form.form-signin").on('beforeSubmit', function () {
        $(".btn-animate").toggleClass("btn-animate-grow");
        $(".welcome").toggleClass("welcome-left");
        $(".cover-photo").toggleClass("cover-photo-down");
//  $(".frame").toggleClass("frame-short");
        $(".profile-photo").toggleClass("profile-photo-down");
        $(".btn-goback").toggleClass("btn-goback-up");
        $(".forgot").toggleClass("forgot-fade");

        return false;
    });
});

$(function () {
    $('form').on('mouseenter mouseleave', 'input[aria-invalid="true"]', function (e) {
        $(e.target).next('.help-block').toggleClass('hidden');
    });
});
