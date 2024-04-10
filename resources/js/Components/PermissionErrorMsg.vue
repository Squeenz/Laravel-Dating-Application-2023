<script setup>
const props = defineProps({
    role: Object
});

</script>

<template>
    <div class="p-2 bg-gray-900 text-center rounded-lg">
        <h1 class="text-red-600 text-2xl">Error role: {{ props.role[0] }}</h1>
        <h1 class="text-orange-300">Does not have the permissions needed</h1>
        <p class="text-white">Contact your administrator</p>
    </div>
</template>
