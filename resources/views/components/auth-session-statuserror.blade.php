@props(['email'])

@if ($email)
    <div {{ $attributes->merge(['class' => 'alert ']) }} role="alert">
        {{$email}}
    </div>
@endif
