@component('mail::message')
<strong>{{ __('From') }}:</strong>{{ $data['name'] }}<br />
<strong>{{ __('Contact Details:') }}</strong>{{ $data['contactDetails'] }}<br />
<strong>{{ __('Comments:') }}</strong>{{ $data['comments'] }}<br />
<br />
<strong>{{ __('Order:') }}</strong>
@component('mail::table')

| {{ __('Title') }}     | {{ __('Description') }}     | {{ __('Price') }}     |
|:---------------------:|:---------------------------:|:---------------------:|
@foreach ($products as $product)
| {{ $product->title }} | {{ $product->description }} | {{ $product->price }} |
@endforeach
|                       |   {{ __('Total Price')}}    |     {{ $price }}      |

@endcomponent
@endcomponent
