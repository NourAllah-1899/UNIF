<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Sidebar from '@/Components/Sidebar.vue'

import { Head } from '@inertiajs/vue3';
</script>
<template>
  <div class="app-container">
    <Sidebar />
    <main class="main-content">
      <slot />
    </main>
  </div>
</template>

