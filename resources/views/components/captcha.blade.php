{!! '<div class="flex items-center">
    <img 
        src="' .
    route('captcha.generate') .
    '" 
        alt="驗證碼" 
        class="h-8 cursor-pointer" 
        style="border-radius: 4px;"
        onclick="this.src=\'' .
    route('captcha.generate') .
    '?\'+Math.random()"
    >
</div>' !!}
