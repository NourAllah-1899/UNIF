<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    categories: Array,
    currencies: Array
});

const emit = defineEmits(['close']);

const form = useForm({
    date: new Date().toISOString().split('T')[0],
    type: 'expense',
    name: '',
    value: '',
    currency: 'TND',
    status: 'completed',
    category_id: null,
    notes: ''
});

const submit = () => {
    form.post(route('transactions.store'), {
        onSuccess: () => {
            emit('close');
            form.reset();
        }
    });
};
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Add New Transaction</h2>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Date -->
                <div>
                    <InputLabel for="date" value="Date" />
                    <TextInput id="date" type="date" v-model="form.date" class="mt-1 block w-full" />
                </div>

                <!-- Type -->
                <div>
                    <InputLabel for="type" value="Type" />
                    <SelectInput id="type" v-model="form.type" class="mt-1 block w-full">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </SelectInput>
                </div>

                <!-- Name -->
                <div class="md:col-span-2">
                    <InputLabel for="name" value="Description" />
                    <TextInput id="name" type="text" v-model="form.name" class="mt-1 block w-full" />
                </div>

                <!-- Amount -->
                <div>
                    <InputLabel for="value" value="Amount" />
                    <div class="flex mt-1">
                        <SelectInput v-model="form.currency" class="w-20 mr-2">
                            <option v-for="currency in currencies" :value="currency.code">{{ currency.code }}</option>
                        </SelectInput>
                        <TextInput id="value" type="number" step="0.01" v-model="form.value" class="flex-1" />
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <InputLabel for="status" value="Status" />
                    <SelectInput id="status" v-model="form.status" class="mt-1 block w-full">
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </SelectInput>
                </div>

                <!-- Category -->
                <div>
                    <InputLabel for="category_id" value="Category" />
                    <SelectInput id="category_id" v-model="form.category_id" class="mt-1 block w-full">
                        <option value="">Select Category</option>
                        <option v-for="category in categories" :value="category.id">
                            {{ category.name }}
                        </option>
                    </SelectInput>
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <InputLabel for="notes" value="Notes" />
                    <TextInput id="notes" type="text" v-model="form.notes" class="mt-1 block w-full" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <PrimaryButton type="button" @click="emit('close')" class="mr-2 bg-gray-500 hover:bg-gray-600">
                    Cancel
                </PrimaryButton>
                <PrimaryButton type="submit" :disabled="form.processing">
                    Save Transaction
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
