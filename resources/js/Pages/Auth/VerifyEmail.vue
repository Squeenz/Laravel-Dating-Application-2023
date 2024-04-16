<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { HeartHandshake, MailQuestion } from 'lucide-vue-next';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="w-full sm:max-w-3xl mt-6 px-6 py-4 bg-[#0A0A0A] shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <MailQuestion class="text-red-700 mx-auto" :size="100"/>
            <div class="mb-4 text-sm text-white">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
                A new verification link has been sent to the email address you provided during registration.
            </div>

            <form @submit.prevent="submit">
                <div class="mt-4 flex items-center justify-between">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Resend Verification Email
                    </PrimaryButton>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-red-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >Log Out</Link
                    >
                </div>
            </form>
        </div>

        <div class="w-full sm:max-w-3xl mt-6 px-6 py-4 bg-[#0A0A0A] shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <div class="text-sm text-white">
                <HeartHandshake class="text-red-700 my-2 mr-5 float-left" :size="30"/>
                <p>After you verify your account, you will need to setup your attributes and prefrences. This will help us find you a good match</p>
            </div>
        </div>
    </GuestLayout>
</template>
