// Обработка отправки форм через Contact Form 7
export function initForms() {
    // Проверяем наличие pushAjax
    if (typeof pushAjax === 'undefined') {
        console.error('pushAjax is not defined. Make sure scripts are properly enqueued.');
        return;
    }
    
    const forms = document.querySelectorAll('.pushstart-form, .formfooter-form');
    
    if (!forms.length) {
        return;
    }
    
    forms.forEach(form => {
        const formId = form.getAttribute('data-form-id');
        if (!formId || formId === '') {
            console.warn('Form ID not found for form:', form);
            // Отключаем стандартную отправку даже если ID нет
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.error('Form ID is missing. Please set the form ID in WordPress options.');
            });
            return;
        }
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const formName = this.classList.contains('pushstart-form') ? 'pushstart' : 'formfooter';
            const formData = new FormData(this);
            formData.append('action', 'push_cf7_submit');
            formData.append('form_id', formId);
            formData.append('form_name', formName);
            formData.append('nonce', pushAjax.nonce);
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalContent = submitButton ? submitButton.innerHTML : '';
            const responseOutput = this.querySelector('.wpcf7-response-output');
            
            // Блокируем кнопку отправки
            if (submitButton) {
                submitButton.disabled = true;
                const buttonText = submitButton.querySelector('span');
                if (buttonText) {
                    buttonText.textContent = 'Відправка...';
                }
            }
            
            // Очищаем предыдущие сообщения
            if (responseOutput) {
                responseOutput.textContent = '';
                responseOutput.classList.remove('wpcf7-mail-sent-ok', 'wpcf7-validation-errors', 'wpcf7-mail-sent-ng');
                responseOutput.setAttribute('aria-hidden', 'true');
            }
            
            // Проверяем наличие необходимых данных
            if (!pushAjax.ajaxurl || !pushAjax.nonce) {
                console.error('pushAjax configuration is incomplete');
                if (responseOutput) {
                    responseOutput.textContent = 'Помилка конфігурації. Спробуйте пізніше.';
                    responseOutput.classList.add('wpcf7-validation-errors');
                    responseOutput.setAttribute('aria-hidden', 'false');
                }
                if (submitButton) {
                    submitButton.disabled = false;
                    if (originalContent) {
                        submitButton.innerHTML = originalContent;
                    }
                }
                return;
            }
            
            fetch(pushAjax.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Успешная отправка
                    if (responseOutput) {
                        responseOutput.textContent = data.data.message || 'Дякуємо! Ваше повідомлення відправлено.';
                        responseOutput.classList.add('wpcf7-mail-sent-ok');
                        responseOutput.setAttribute('aria-hidden', 'false');
                    }
                    
                    // Очищаем форму
                    this.reset();
                    
                    // Скрываем сообщение через 5 секунд
                    setTimeout(() => {
                        if (responseOutput) {
                            responseOutput.textContent = '';
                            responseOutput.classList.remove('wpcf7-mail-sent-ok');
                            responseOutput.setAttribute('aria-hidden', 'true');
                        }
                    }, 5000);
                } else {
                    // Ошибка валидации или отправки
                    if (responseOutput) {
                        responseOutput.textContent = data.data.message || 'Помилка відправки. Спробуйте пізніше.';
                        responseOutput.classList.add('wpcf7-validation-errors');
                        responseOutput.setAttribute('aria-hidden', 'false');
                    }
                    
                    // Подсвечиваем невалидные поля
                    if (data.data.invalid_fields) {
                        Object.keys(data.data.invalid_fields).forEach(fieldName => {
                            const field = this.querySelector(`[name="${fieldName}"]`);
                            if (field) {
                                field.classList.add('wpcf7-not-valid');
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
                if (responseOutput) {
                    responseOutput.textContent = 'Помилка відправки. Спробуйте пізніше.';
                    responseOutput.classList.add('wpcf7-validation-errors');
                    responseOutput.setAttribute('aria-hidden', 'false');
                }
            })
            .finally(() => {
                // Разблокируем кнопку
                if (submitButton) {
                    submitButton.disabled = false;
                    if (originalContent) {
                        submitButton.innerHTML = originalContent;
                    } else {
                        const buttonText = submitButton.querySelector('span');
                        if (buttonText && formName === 'formfooter') {
                            buttonText.textContent = 'Зв\'язатись з нами';
                        }
                    }
                }
                
                // Убираем классы ошибок с полей через некоторое время
                setTimeout(() => {
                    const invalidFields = this.querySelectorAll('.wpcf7-not-valid');
                    invalidFields.forEach(field => {
                        field.classList.remove('wpcf7-not-valid');
                    });
                }, 3000);
            });
        });
    });
}

