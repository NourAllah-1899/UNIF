<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    transaction: Object,
    categories: Array,
    currencies: Array
});

const emit = defineEmits(['close']);

const form = useForm({
    date: props.transaction.date,
    type: props.transaction.type,
    name: props.transaction.name,
    value: props.transaction.value,
    currency: props.transaction.currency,
    status: props.transaction.status,
    category_id: props.transaction.category_id,
    notes: props.transaction.notes
});

const submit = () => {
    form.put(route('transactions.update', props.transaction.id), {
        onSuccess: () => {
            emit('close');
        }
    });
};
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Transaction</h2>

        <form @submit.prevent="submit">
            <!-- Same form structure as AddTransaction.vue -->
            <!-- Just change the submit button text -->
            <div class="mt-6 flex justify-end">
                <PrimaryButton type="button" @click="emit('close')" class="mr-2 bg-gray-500 hover:bg-gray-600">
                    Cancel
                </PrimaryButton>
                <PrimaryButton type="submit" :disabled="form.processing">
                    Update Transaction
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
