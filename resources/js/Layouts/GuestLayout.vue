<script setup>
import Navigation from '@/Components/Navigation.vue';
</script>

<template>
    <div class="min-h-screen bg-[#1A1A1A]">
        <Navigation/>

        <!-- Page Heading -->
        <header class="bg-[#8e8e8e] shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-[5rem] px-4 sm:px-6 lg:px-10 text-[1.4rem]">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>

    </div>
</template>
