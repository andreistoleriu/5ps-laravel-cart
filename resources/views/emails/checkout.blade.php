@component('mail::message')
<strong>{{ __('From') }}:</strong>{{ $data['name'] }}<br />
<strong>{{ __('Contact Details:') }}</strong>{{ $data['contactDetails'] }}<br />
<strong>{{ __('Comments:') }}</strong>{{ $data['comments'] }}<br />
<br />
<strong>{{ __('Order:') }}</strong>

@component('mail::table')
<table border="1" cellpadding="3">
<tr>
<th align="middle">{{ __('Title') }}</th>
<th align="middle">{{ __('Description') }}</th>
<th align="middle">{{ __('Price') }}</th>
</tr>

@foreach ($products as $product)
<tr>
<td align="middle">{{ $product->title }}</td>
<td align="middle">{{ $product->description }}</td>
<td align="middle">{{ $product->price }}</td>
</tr>
@endforeach
<tr>
<td colspan="2" align="middle">
{{ __('Price') }}
</td>
<td colspan="1" align="middle"><strong>{{ $price }}</strong></td>
</tr>
</table>
@endcomponent
@endcomponent
