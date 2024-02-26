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
                        <div class="flex gap-1 flex-wrap">
                            <div v-for="photo in userPhotos" :key="photo.id" class=" rounded-[0.1rem] bg-red-900 border-2 border-red-600 mx-[2.6rem] my-[1rem]">
                                <img
                                class="h-[15rem]"
                                :src="route('photos.get', photo.photo)"
                                :alt="photo.photo + ' photo'"
                                width="200"
                                />
                                <Link
                                    :href="route('photos.destroy', photo.id)"
                                    method="delete"
                                    as="button"
                                    class="w-full justify-center relative text-red-500"
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
