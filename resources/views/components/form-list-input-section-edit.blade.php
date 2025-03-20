<div class="{{ $size }}">
  <x-form-input-label :for="$name" :value="$label" />
  <x-form-list-input-field-edit :id="$id" :name="$name" :options="$options" :value="$value" :valuename="$valuename" />
  @error($name) <span  class="text-red-500">{{ $message }}</span> @enderror
</div>