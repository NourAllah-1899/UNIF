<script setup>
const props = defineProps({
    transaction: Object
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h2>
        <p class="text-sm text-gray-600 mb-6">
            Are you sure you want to delete this transaction?
            <span class="font-medium block mt-2">{{ transaction.name }} - {{ transaction.value }} {{ transaction.currency }}</span>
        </p>

        <div class="flex justify-end">
            <PrimaryButton @click="emit('cancel')" class="mr-2 bg-gray-500 hover:bg-gray-600">
                Cancel
            </PrimaryButton>
            <DangerButton @click="emit('confirm')">
                Delete Transaction
            </DangerButton>
        </div>
    </div>
</template>
