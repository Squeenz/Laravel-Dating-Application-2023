<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { ChevronDown, ChevronRight } from 'lucide-vue-next';

const open = ref(true);

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const activeClass = computed(() => {
    return open.value
        ? "flex justify-between p-2 bg-gray-800 text-red-600 hover:bg-gray-800 hover:text-red-600 transition duration-150 ease-in-out"
        : "flex justify-between p-2 text-white hover:bg-gray-800 hover:text-red-600 transition duration-150 ease-in-out";
});
</script>

<template>
    <div class="relative">
        <div @click="open = !open" :class="activeClass">
            <slot name="trigger" />
            <ChevronRight v-if="!open"/>
            <ChevronDown v-else/>
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed" @click="open = false"></div>

        <div
            v-show="open"
            class="w-auto"
            style="display: none"
            @click="open = false"
        >
            <div>
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
