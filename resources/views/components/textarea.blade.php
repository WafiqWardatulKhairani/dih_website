@props(['name', 'label' => null, 'value' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 font-medium mb-1">{{ $label }}</label>
    @endif
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500', 'rows' => 4]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
