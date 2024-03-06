<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Welcome" />


    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">

    <template #header>
        <h1 class="text-white">
            Have any issues with our service? no problem just submit a support ticket and we will respond as soon as possilbe.
        </h1>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[2rem] bg-[#0A0A0A] shadow rounded-sm">
                <div class="flex flex-wrap justify-center text-white">
                    <div>
                        <form>
                            <InputLabel for="type" class="text-red-600">Your Email (Mandatory)</InputLabel>
                            <TextInput name="email" class="w-full text-black"/>

                            <InputLabel for="type" class="text-red-600">Contact Reason (Mandatory)</InputLabel>
                            <select name="options" class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm">
                                <option
                                        v-for="n in 4"
                                        :key="n"
                                        class="text-black"
                                    >
                                    Option {{ n }}
                                </option>
                            </select>

                            <InputLabel for="type" class="text-red-600">Description (Mandatory)</InputLabel>
                            <Textarea name="desc" class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm"></Textarea>

                            <InputLabel for="type" class="text-red-600">Attachments (optional)</InputLabel>
                            <div class="sm:m-auto">
                                <input class="ml-[8rem] my-[2rem] " type="file" @change="handlePhoto" accept="image/*" multiple>
                            </div>

                            <PrimaryButton class="w-full justify-center">Submit</PrimaryButton>
                        </form>
                    </div>
                </div>
          </div>
    </div>

    </GuestLayout>
</template>
