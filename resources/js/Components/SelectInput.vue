<template>
  <select
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
  >
    <option value="" disabled>Select an option</option>
    <option v-for="option in options" :key="option.value" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script>
export default {
  props: {
    modelValue: [String, Number],
    options: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  emits: ['update:modelValue']
}
</script>