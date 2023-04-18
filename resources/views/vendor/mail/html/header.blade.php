@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<x-logo></x-logo>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
