@props(['errors', 'bag' => 'default'])

@if (($errors->$bag)->any())
<div {{ $attributes }}>
    <div class="font-medium text-red-600">
        {{ __('Whoops! Something went wrong.') }}
    </div>

    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
        @foreach (($errors->$bag)->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
