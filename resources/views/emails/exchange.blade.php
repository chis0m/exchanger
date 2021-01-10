@component('mail::message')
Hello <span class="bold">{{ $user->first_name }}</span>

  {!! $message !!}

@if($button_text)
@component('mail::button', ['url' => $url])
{{ $button_text }}
@endcomponent
@endif

{!! $end_message !!}

For more information or assistance, send an email to <a href="mailto:hello@exchanger.com">hello@exchanger.com</a> or call our Customer Support Team on <a href="tel:+2340864299949">+2340864299949</a>.

@if (App::environment('production'))
Thank you for choosing Exchanger.
@else
<p style="color:red;font-size:16">Test Environment!</p>
@endif

@endcomponent