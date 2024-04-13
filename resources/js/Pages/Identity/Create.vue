<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    self: '',
    document: '',
});

const handlePhoto = (event, type) => {
    if (type === 'self')
    {
        form.self = event.target.files;
    }
    else if (type === 'document')
    {
        form.document = event.target.files;
    }
};

</script>

<template>
    <Head title="Identity Verification" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <div class="bg-gray-900 p-[2rem] grid grid-flow-row gap-2 text-center">
                        <h1 class="text-orange-500 text-2xl">Notice</h1>
                        <p>In order for you to use our service, we need to verify <br/>
                            that you are who you say you are and that you are actually 18 and over</p>
                        <p class=" font-bold">Once your account is verified, sensitive information will be deleted.</p>

                       <a :href="route('policies.index')" target="_blank"> <p class="text-gray-500">Want to find out what information we store about you, and how we use it? (click here)</p></a>
                    </div>

                    <div class="p-[1rem]">
                        <p>To verify your identity, please provide two images:</p>
                        <ol>
                            <li>An image of your face:</li>
                            <ul class="ml-[2rem] list-decimal">
                                <li>Ensure your entire face is well-lit and clearly visible.</li>
                                <li>Avoid wearing sunglasses, hats, or anything that obscures your face.</li>
                                <li>Look directly at the camera with a neutral expression.</li>
                            </ul>
                            <li>Upload a document that confirms your identity, such as a Passport, Driver's License, or National Identification Card</li>
                        </ol>

                        <form class="text-center" @submit.prevent="form.post(route('identity.store'))">
                            <section class="my-[1rem]">
                                <InputLabel class="text-orange-400 p-[1rem]">Self Image</InputLabel>
                                <InputError :message="form.errors.self"/>
                                <input class="ml-[8rem]" type="file" @change="handlePhoto($event, 'self')" accept="image/*">
                            </section>

                            <section class="my-[1rem]">
                                <InputLabel class="text-orange-400 p-[1rem]">Document Image</InputLabel>
                                <InputError :message="form.errors.document"/>
                                <input class="ml-[8rem]" type="file" @change="handlePhoto($event, 'document')" accept="image/*">
                            </section>

                            <PrimaryButton class="w-full justify-center mt-[1rem]">Submit</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
