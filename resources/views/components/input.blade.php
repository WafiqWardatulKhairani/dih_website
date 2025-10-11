@props(['name', 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-medium mb-1">{{ ucwords(str_replace('_', ' ', $name)) }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}" 
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500']) }}
    >
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
