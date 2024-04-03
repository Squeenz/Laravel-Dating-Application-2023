<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Trash2 } from 'lucide-vue-next';

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
                        <div class="flex flex-wrap">
                            <div v-for="photo in userPhotos" :key="photo.id" class="rounded-[0.1rem] mx-[1.7rem] grid">
                                <Link
                                    :href="route('photos.destroy', photo.id)"
                                    method="delete"
                                    as="button"
                                    class="float-right text-red-700"
                                >
                                    <Trash2 class="float-right relative top-7 border-1 border-red-700 bg-black p-1 rounded-sm" :size="30"/>
                                </Link>

                                <img
                                class="h-[15rem] float-left"
                                :src="route('photos.get', photo.photo)"
                                :alt="photo.photo + ' photo'"
                                />
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </AuthenticatedLayout>
</template>
