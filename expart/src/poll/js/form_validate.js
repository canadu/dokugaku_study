validate_form();
//フロントで側でチェックを行っていてもすり抜けは可能なので必ずバックエンド側でもチェックは行うこと！！
function validate_form() {
    const $inputs = document.querySelectorAll('.validate-target');
    const $form = document.querySelector('.validate-form');

    if (!$form)
    {
        return;
    }

    //入力コントロール文処理を繰り返す
    for (const $input of $inputs)
    {
        $input.addEventListener('input', function (event) {

            const $target = event.currentTarget;

            const $feedback = $target.nextElementSibling;

            activateSubmitBtn($form);

            if (!$feedback.classList.contains('invalid-feedback'))
            {
                //他のチェック項目でエラーになっているときは他のチェックは行わない
                return;
            }

            if ($target.checkValidity())
            {
                //エラーがない場合
                $target.classList.add('is-valid');
                $target.classList.remove('is-invalid');
                $feedback.textContent = '';
            } else
            {
                //エラーがある場合
                $target.classList.add('is-invalid');
                $target.classList.remove('is-valid');
                if ($target.validity.valueMissing) 
                {
                    $feedback.textContent = '値の入力が必須です';
                } else if ($target.validity.tooShort)
                {
                    $feedback.textContent = $target.minLength + '字以上で入力してください。';
                } else if ($target.validity.tooLong)
                {
                    $feedback.textContent = $target.maxLength + '文字以下で入力してください。';
                } else if ($target.validity.patternMismatch)
                {
                    $feedback.textContent = '半角英数字で入力してださい';
                }
            }
        });
    }
}

function activateSubmitBtn($form) {
    const $submitBtn = $form.querySelector('[type=submit]');
    if ($form.checkValidity())
    {
        //エラーなし
        $submitBtn.removeAttribute('disabled');
    } else
    {
        //エラーあり
        $submitBtn.setAttribute('disabled', true);
    }
}