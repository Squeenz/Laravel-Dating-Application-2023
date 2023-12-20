<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps(['userPhotos']);

</script>

<template>
    <Head title="Remove Photos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Remove Photos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-[1rem]">
                    <h1 class="text-[2rem] text-center">Remove Photos</h1>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex gap-4 flex-wrap flex-row justify-evenly">
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
