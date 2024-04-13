<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
</script>

<template>
    <Head title="Identity Verification" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <div class="bg-gray-900 p-[2rem] grid grid-flow-row gap-2 text-center">
                        <h1 class="text-orange-500 text-2xl">Status</h1>
                        <p>Your account has not been verified yet. We apologize for the inconvenience.<br/>
                            Our staff team will try to verify your account as soon as possible. Once your account has been verified, you will receive an email.</p>

                        <a :href="route('policies.index')" target="_blank">
                            <p class="text-gray-500">Want to find out what information we store about you, and how we use it? (Click here)</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
