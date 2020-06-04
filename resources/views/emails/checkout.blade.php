@component('mail::message')
<strong>From:</strong>{{ $data['name'] }}<br />
<strong>Contact Details:</strong>{{ $data['contactDetails'] }}<br />
<strong>Comments:</strong>{{ $data['comments'] }}<br />
<br />
<strong>Order:</strong>
@component('mail::table')
<table border="1" cellpadding="3">
<tr>
<th></th>
<th align="middle">{{ __('Title') }}</th>
<th align="middle">{{ __('Description') }}</th>
<th align="middle">{{ __('Price') }}</th>
</tr>

@foreach ($products as $product)
<?php $price += $product->price ?>
<tr>
<td align="middle">
    @if ($product->image)
        <img src="{{ asset('storage/images/' . $product->image) }}" width="200px">
    @else
        {{ __('No image') }}
    @endif
</td>
<td align="middle">{{ $product->title }}</td>
<td align="middle">{{ $product->description }}</td>
<td align="middle">{{ $product->price }}</td>
</tr>
@endforeach
<tr>
<td colspan="3" align="middle">
{{ __('Price') }}
</td>
<td colspan="1" align="middle"><strong>{{ $price }}</strong></td>
</tr>
</table>
@endcomponent
@endcomponent
