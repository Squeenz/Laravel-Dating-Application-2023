<script setup>
import { Link } from '@inertiajs/vue3';
import { Dot } from 'lucide-vue-next';


defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 bg-gray-900 text-start text-sm leading-5 text-red-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <Dot class="float-left relative bottom-[0.1rem]"/><slot />
    </Link>
</template>
