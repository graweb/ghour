@component('mail::message')
# Hi {{$client}}

The developer **{{$developer}}** {{$status}} the task **{{$task}}** in the **{{$project}}** project.

{{$status}} at: **{{$datetime}} hs**<br><br>

Thanks,<br>
Team {{ config('app.name') }}<br>
By <a href="https://www.graweb.com.br" target="_blank">Graweb Tecnologia</a>
@endcomponent
