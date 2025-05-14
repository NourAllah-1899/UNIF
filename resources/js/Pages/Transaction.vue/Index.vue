<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import AddTransaction from './AddTransaction.vue';
import EditTransaction from './EditTransaction.vue';
import DeleteConfirmation from './DeleteConfirmation.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';

const props = defineProps({
    transactions: Object,
    filters: Object,
    message: String,
    summary: Object,
    categories: Array,
    currencies: Arrays
});

const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const currentTransaction = ref(null);

const form = useForm({
    filter: props.filters.filter,
});

const openAddModal = () => {
    showAddModal.value = true;
};

const openEditModal = (transaction) => {
    currentTransaction.value = transaction;
    showEditModal.value = true;
};

const openDeleteModal = (transaction) => {
    currentTransaction.value = transaction;
    showDeleteModal.value = true;
};

const deleteTransaction = () => {
    form.delete(route('transactions.destroy', currentTransaction.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
        }
    });
};
</script>

<template>
    <Head title="Transactions" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transactions
                <PrimaryButton @click="openAddModal" class="ml-4">
                    Add Transaction
                </PrimaryButton>
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-green-800 font-medium">Income</h3>
                        <p class="text-2xl font-bold text-green-600">{{ summary.income }} TND</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="text-red-800 font-medium">Expenses</h3>
                        <p class="text-2xl font-bold text-red-600">{{ summary.expense }} TND</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-blue-800 font-medium">Balance</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ summary.balance }} TND</p>
                    </div>
                </div>

                <!-- Success Message -->
                <div v-if="message" class="p-4 mb-4 bg-green-100 text-green-700 rounded-lg">
                    {{ message }}
                </div>

                <!-- Transactions Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="transaction in transactions.data" :key="transaction.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ new Date(transaction.date).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ transaction.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ transaction.category?.name || 'Uncategorized' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    :class="transaction.type === 'income' ? 'text-green-600' : 'text-red-600'">
                                    {{ transaction.type === 'income' ? '+' : '-' }}{{ transaction.value }} TND
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'bg-green-100 text-green-800': transaction.status === 'completed',
                                        'bg-yellow-100 text-yellow-800': transaction.status === 'pending',
                                        'bg-red-100 text-red-800': transaction.status === 'failed'
                                    }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ transaction.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button @click="openEditModal(transaction)" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                    <button @click="openDeleteModal(transaction)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            <tr v-if="transactions.data.length === 0">
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <Pagination class="mt-4" :links="transactions.links" />
            </div>
        </div>

        <!-- Add Transaction Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false">
            <AddTransaction
                :categories="categories"
                :currencies="currencies"
                @close="showAddModal = false"
            />
        </Modal>

        <!-- Edit Transaction Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false">
            <EditTransaction
                v-if="currentTransaction"
                :transaction="currentTransaction"
                :categories="categories"
                :currencies="currencies"
                @close="showEditModal = false"
            />
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <DeleteConfirmation
                v-if="currentTransaction"
                :transaction="currentTransaction"
                @confirm="deleteTransaction"
                @cancel="showDeleteModal = false"
            />
        </Modal>
    </AuthenticatedLayout>
</template>
