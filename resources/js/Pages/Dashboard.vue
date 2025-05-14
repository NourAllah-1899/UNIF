
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
defineOptions({
  layout: AppLayout,
})
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

    </AuthenticatedLayout>
</template>

