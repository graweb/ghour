@component('mail::message')
# Hi {{$client}}

The project **{{$project}}** was started by **{{$user}}**.

Started at: **{{$datetime}} hs**<br><br>

Thanks,<br>
Team {{ config('app.name') }}<br>
By <a href="https://www.graweb.com.br" target="_blank">Graweb Tecnologia</a>
@endcomponent
