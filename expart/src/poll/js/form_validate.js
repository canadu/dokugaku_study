init();
function init() {
    const $input = document.querySelector('.validate-target');
    $input.addEventListener('input', function (event) {
        const $target = event.currentTarget;
        if ($target.validity.valueMissing)
        {
            alert('値の入力が必須です');
        } else if ($target.validity.tooShort)
        {
            alert($target.minLength + '文字以上で入力してください。値の入力が必須です。');
        } else if ($target.validity.tooLong)
        {
            alert($target.maxLength + '文字以下で入力してください。値の入力が必須です。');
        } else if ($target.validity.patternMismatch)
        {
            alert('半角英数字で入力してください');
        }
    });
    // console.dir($input);
}