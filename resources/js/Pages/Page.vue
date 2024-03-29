<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DisplayBlocks from '@/Components/DisplayBlocks.vue';

const props = defineProps({
    pages: Object,
    displayBlocks: Object,
});
</script>

<template>
    <Head title="Welcome" />
    <GuestLayout :pages="props.pages">

    <template #header>
        <h1 class="text-white text-center">Welcome to our site, we are a new dating service which focuses on gamers and non-profit service model. Unlike majority of
            dating applications we don't charge for basic features that people should have access to.
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[1.8rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center text-white">
                    <DisplayBlocks
                        v-for="block in props.displayBlocks"
                        :key="block.id"
                        :type="block.type"
                        :content="block.contents"
                    />
                </div>
          </div>
    </div>
    </GuestLayout>
</template>
