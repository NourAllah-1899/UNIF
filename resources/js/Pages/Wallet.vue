
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
        </template>

    </AuthenticatedLayout>
</template>

