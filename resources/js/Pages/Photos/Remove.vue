<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps(['userPhotos']);

</script>

<template>
    <Head title="Remove Photos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Remove Photos
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="sm:h-[51.3rem] sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                        <div class="flex gap-1 flex-wrap justify-between">
                            <div v-for="photo in userPhotos" :key="photo.id">
                                <img
                                class="h-[15rem]"
                                :src="route('photos.get', photo.photo)"
                                :alt="photo.photo + ' photo'"
                                />
                                <Link
                                    :href="route('photos.destroy', photo.id)"
                                    method="delete"
                                    as="button"
                                    class="w-full justify-center relative bottom-7 text-red-500"
                                >
                                Delete
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </AuthenticatedLayout>
</template>
