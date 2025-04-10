@props([
    'id',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false
])

<div class="mb-4">
    <x-input-label :for="$id" :value="$label" />
    <x-text-input :id="$id" :name="$id" :type="$type" class="mt-1 w-full"
                  :value="$value" :required="$required" />
    <x-input-error :messages="$errors->get($id)" class="mt-2" />
</div>
