<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#111111]">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-red-800" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-3xl mt-6 px-6 py-4 bg-[#0A0A0A] shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
