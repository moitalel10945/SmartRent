@php $isLandlord = auth()->user()->role === 'landlord'; @endphp

@if($isLandlord)
    <x-landlord>
        @include('profile._form')
    </x-landlord>
@else
    <x-tenant>
        @include('profile._form')
    </x-tenant>
@endif