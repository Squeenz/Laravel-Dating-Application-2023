<script setup>
import { Head, Link} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';

const props = defineProps({
    policies: Array
})

</script>

<template>
    <Head title="Policies" />

    <GuestLayout>
        <template #header>
            <p class=" text-white text-center">
                We're committed to providing you with a safe and enjoyable experience. To ensure transparency and clarity,
                please review our policies below. By using our website, you agree to abide by these policies and guidelines.
            </p>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:py-[1.5rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center m-1 gap-3 text-white w-full">
                    <div v-for="(policy, index) in props.policies"
                        :key="policy"
                        class="bg-[#1A1A1A] p-5 rounded-md grid grid-flow-row w-[20rem] text-center"
                        :class="index + 1 === props.policies.length ? 'md:w-[61.5rem]' : ''"
                    >
                        <h1 class="font-bold m-2 text-2xl">{{ policy.title }}</h1>
                        <p class="m-1">Created: {{ dayjs(policy.created_at).format('DD/MM/YYYY H:m:s a') }}</p>
                        <p class="m-1">Updated: {{ dayjs(policy.updated_at).format('DD/MM/YYYY H:m:s a') }}</p>
                        <Link :href="route('policies.show', policy)" class="mt-[1rem] mx-[1rem]"><PrimaryButton class="bg-red-900 justify-center w-full">READ NOW</PrimaryButton></Link>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
