<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';


</script>

<template>
    <Head title="Users" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                User control panel
            </h2>
        </template>

        <div>
            <div class="mx-auto">
                <div class="bg-[#0A0A0A] h-[92vh] shadow rounded-sm text-white">
                    <h1>test</h1>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
