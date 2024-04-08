<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    reason: '',
    message: '',
});

const options = [
    "Account Assistance",
    "Profile Management",
    "Technical Support",
    "Privacy Concerns",
    "Feedback and Suggestions",
    "Other Inquiries"
];

</script>

<template>
    <Head title="Create a Ticket" />


    <GuestLayout>

    <template #header>
        <h1 class="text-white text-center">
            Have any issues with our service? no problem just submit a support ticket and we will respond as soon as possilbe.
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[2rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="mx-[2rem] justify-center text-white">
                    <form @submit.prevent="form.post(route('support.store'))" class="bg-[#1A1A1A] p-2 rounded-[0.2rem]">
                        <InputLabel for="type" class="text-white my-2">Contact Reason (Mandatory)</InputLabel>
                        <select name="options" class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm" v-model="form.reason">
                            <option
                                    v-for="option in options"
                                    :key="option"
                                    class="text-black"
                                >
                                {{ option }}
                            </option>
                        </select>

                        <InputLabel for="type" class="text-white my-2">Message (Mandatory)</InputLabel>
                        <textarea name="desc" class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm resize-none h-[10rem]" v-model="form.message"></textarea>
                        <PrimaryButton class="w-full justify-center my-[1rem]">Submit</PrimaryButton>
                    </form>
                </div>
          </div>
    </div>

    </GuestLayout>
</template>
