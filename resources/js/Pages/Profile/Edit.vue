<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';  // Added Link import
import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({
  layout: AppLayout,
});

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <div class="profile-container">
        <div class="profile-content">
            <div class="title-container">
                <Link :href="route('dashboard')" class="back-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </Link>
                <h2 class="page-title">Profile Settings</h2>
            </div>

            <div class="card-grid">
                <!-- First row - single wide card -->
                <div class="profile-card wide-card">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <!-- Second row - two equal cards -->
                <div class="card-row">
                    <div class="profile-card">
                        <UpdatePasswordForm />
                    </div>

                    <div class="profile-card danger-zone">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.profile-container {
    padding: 2rem;
    min-height: 100vh;
    background-color: #f5f9ff;
    overflow-y: auto;
    height: 100vh;
    position: fixed;
    right: 0;
    left: 250px;
    top: 0;
}

.profile-content {
    max-width: 1400px;
    margin: 0 auto;
}

.title-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.back-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.back-arrow:hover {
    background-color: #e0e7ff;
    transform: translateX(-2px);
}

.back-arrow svg {
    width: 20px;
    height: 20px;
}

.page-title {
    color: #07162d;
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
}

/* Rest of your existing styles remain the same */
.card-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.card-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.profile-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(30, 100, 200, 0.1);
    padding: 2rem;
    border-left: 4px solid #3b82f6;
    transition: all 0.3s ease;
}

.wide-card {
    grid-column: span 2;
}

.profile-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(30, 100, 200, 0.15);
}

.danger-zone {
    border-left-color: #ef4444;
    background-color: #fff5f5;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .profile-container {
        margin-left: 250px;
        padding: 2rem;
        min-height: 100vh;
        background-color: #f5f9ff;
        overflow-y: auto;
        height: 100vh;
        position: fixed;
        right: 0;
        left: 250px;
        top: 0;
    }
}

@media (max-width: 1024px) {
    .card-row {
        grid-template-columns: 1fr;
    }

    .wide-card {
        grid-column: span 1;
    }
}

@media (max-width: 768px) {
    .profile-container {
        position: static;
        left: auto;
        height: auto;
        min-height: 100vh;
        margin-left: 0;
    }

    .profile-card {
        padding: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .title-container {
        margin-bottom: 1.5rem;
    }
}
</style>
