$(document).ready(function(){
    $('#reg_form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 15
            },
            phone: 'required',
            lastname: {
                required: true,
                maxlength: 20,
                minlength: 2
            },
            email: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8

            },
        },  
        messages: {
            name: {
                required: "Пожалуйста, введите своё имя",
                minlength: "Длина имени должна быть больше 2-х символов",
                maxlength: "Длина имени не должна превышать 15 символов"
            },
            phone: 'Пожалуйста, введите свой номер телефона',
            lastname: {
                required: "Пожалуйста, введите свою фамилию",
                minlength: "Длина имени должна быть больше 2-х символов",
                maxlength:  "Длина имени не должна превышать 20 символов",
            },
            email: 'Пожалуйста, введите свой адрес электронной почты',
            password: {
                required: "Пожалуйста, введите свой пароль",
                minlength: "Длина пароля должна быть больше 8-ми символов",
            }
        }
    });
    $('input[name=phone]').mask("+7 (999) 999-99-99");
})