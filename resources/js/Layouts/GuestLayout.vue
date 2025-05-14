<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
   <div>
        <div>
            <Link href="/">
            </Link>
        </div>

        <div        >
            <slot />
        </div>
    </div>
</template>
