<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import logo from '../../imgs/logo.png';
import '../../css/Budget.css';

// Get current route name
const currentRoute = computed(() => {
  return router.page.url.split('/')[1] || 'dashboard';
});

// Helper function to check active menu item
const isActive = (routeName) => {
  return currentRoute.value.toLowerCase() === routeName.toLowerCase();
};
</script>

<template>
  <nav class="sidebar">
    <div class="logo">
      <Link :href="route('dashboard')">
        <img :src="logo" alt="UniFein Logo" height="40" width="40" />
        <span id="logo">UniFein</span>
      </Link>
    </div>

    <h5 class="menu-title">Main Menu</h5>

    <ul>
      <li :class="{ active: isActive('dashboard') }">
        <Link :href="route('dashboard')">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path :fill="isActive('dashboard') ? '#3b82f6' : '#a6a6a6'" d="M1 2.25C1 1.56 1.56 1 2.25 1h3.5C6.44 1 7 1.56 7 2.25v11.5C7 14.44 6.44 15 5.75 15h-3.5C1.56 15 1 14.44 1 13.75V2.25zm1.5.25v11h3v-11h-3zM9 2.25C9 1.56 9.56 1 10.25 1h3.5c.69 0 1.25.56 1.25 1.25v3.5C15 6.44 14.44 7 13.75 7h-3.5C9.56 7 9 6.44 9 5.75v-3.5zm1.5.25v3h3v-3h-3zM10.25 9C9.56 9 9 9.56 9 10.25v3.5c0 .69.56 1.25 1.25 1.25h3.5c.69 0 1.25-.56 1.25-1.25v-3.5C15 9.56 14.44 9 13.75 9h-3.5zm.25 4.5v-3h3v3h-3z"/>
          </svg>
          Dashboard
        </Link>
      </li>

      <li :class="{ active: isActive('transactions') }">
        <Link :href="route('transactions.index')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path :fill="isActive('transactions') ? '#3b82f6' : '#949494'" d="M15.2929 3.29289C15.6834 2.90237 16.3166 2.90237 16.7071 3.29289L22.3657 8.95147C23.1216 9.70743 22.5862 11 21.5172 11H2C1.44772 11 1 10.5523 1 10C1 9.44772 1.44772 9 2 9H19.5858L15.2929 4.70711C14.9024 4.31658 14.9024 3.68342 15.2929 3.29289ZM4.41421 15H22C22.5523 15 23 14.5523 23 14C23 13.4477 22.5523 13 22 13H2.48284C1.41376 13 0.878355 14.2926 1.63431 15.0485L7.29289 20.7071C7.68342 21.0976 8.31658 21.0976 8.70711 20.7071C9.09763 20.3166 9.09763 19.6834 8.70711 19.2929L4.41421 15Z"/>
          </svg>
          Transactions
        </Link>
      </li>

      <li :class="{ active: isActive('card-center') }">
        <Link :href="route('card-center.index')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path :fill="isActive('card-center') ? '#3b82f6' : '#b8b7b7'" d="M14.2929 1.29289C14.6834 0.902369 15.3166 0.902369 15.7071 1.29289L23.7071 9.29289C24.0976 9.68342 24.0976 10.3166 23.7071 10.7071L18 16.4142V19C18 20.6569 16.6569 22 15 22H5C2.23858 22 0 19.7614 0 17V8C0 5.79086 1.79086 4 4 4H11.5858L14.2929 1.29289Z"/>
          </svg>
          Card Center
        </Link>
      </li>

      <li :class="{ active: isActive('wallet') }">
        <Link :href="route('wallet.index')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path :stroke="isActive('wallet') ? '#3b82f6' : '#bababa'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M18 8V7.2C18 6.0799 18 5.51984 17.782 5.09202C17.5903 4.71569 17.2843 4.40973 16.908 4.21799C16.4802 4 15.9201 4 14.8 4H6.2C5.07989 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.0799 3 7.2V8M21 12H19C17.8954 12 17 12.8954 17 14C17 15.1046 17.8954 16 19 16H21M3 8V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V11.2C21 10.0799 21 9.51984 20.782 9.09202C20.5903 8.71569 20.2843 8.40973 19.908 8.21799C19.4802 8 18.9201 8 17.8 8H3Z"/>
          </svg>
          Wallet
        </Link>
      </li>
    </ul>

    <div class="footer">
      <b>UniFein Budget Tracker</b>
      <p class="ft1">&copy; <span>2025</span> All Rights Reserved</p>
      <p>Made By Codek <span>3</span>ejja</p>
    </div>
  </nav>
</template>
