<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <!-- Dashboard Header -->
            <header class="content">
                <div class="dashboard-header bg-white border-b border-gray-200">
                    <h1 class="dashboard-title">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            height="20"
                            width="20"
                            class="mr-2"
                        >
                            <path
                                d="M20 7L4 7"
                                stroke="#ababab"
                                stroke-width="1.5"
                                stroke-linecap="round"
                            ></path>
                            <path
                                d="M15 12L4 12"
                                stroke="#ababab"
                                stroke-width="1.5"
                                stroke-linecap="round"
                            ></path>
                            <path
                                d="M9 17H4"
                                stroke="#ababab"
                                stroke-width="1.5"
                                stroke-linecap="round"
                            ></path>
                        </svg>
                        Dashboard
                    </h1>

                    <!-- User Profile Dropdown -->
                    <div class="user-profile">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <div class="flex items-center cursor-pointer">
                                    <div class="user-info mr-3 text-right hidden sm:block">
                                        <div class="user-name font-medium">{{ $page.props.auth.user.name }}</div>
                                        <div class="user-handle text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                                    </div>
                                    <div class="user-avatar bg-gray-200 text-gray-700 font-medium flex items-center justify-center rounded-full h-8 w-8">
                                        {{ $page.props.auth.user.name.substring(0, 2).toUpperCase() }}
                                    </div>
                                </div>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Mobile Navigation -->
            <nav class="sm:hidden bg-white border-b border-gray-200">
                <div class="flex justify-between items-center px-4 py-3">
                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="flex items-center">
                        <ApplicationLogo class="block h-8 w-auto fill-current text-gray-800" />
                    </Link>

                    <!-- Mobile Menu Button -->
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1 px-4">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4 py-3">
                            <div class="font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-1 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>


/* Responsive adjustments */
@media (max-width: 640px) {
    .dashboard-header {
        padding: 0.75rem 1rem;
    }

    .dashboard-title {
        font-size: 1.1rem;
    }

    .user-avatar {
        height: 2rem;
        width: 2rem;
        font-size: 0.875rem;
    }
}
</style>
