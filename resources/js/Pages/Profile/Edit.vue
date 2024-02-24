<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

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

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">Profile</h2>
        </template>

        <div>
            <div class="bg-[#0A0A0A] shadow rounded-sm max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="sm:grid sm:grid-flow-col">
                    <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div class="p-4 sm:p-8  shadow sm:rounded-lg">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>

                <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                    <DeleteUserForm/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
