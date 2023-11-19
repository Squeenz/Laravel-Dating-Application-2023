<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

//Edit the form to take in other fields from the database
const form = useForm({
    username: '',
    first_name: '',
    surname: '',
    age: '',
    email: '',
    location: '',
    photos: '',
    social_media: '',
    interests: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div>
                <InputLabel for="first_name" value="first name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div>
                <InputLabel for="surname" value="surname" />

                <TextInput
                    id="surname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.surname"
                    required
                    autofocus
                    autocomplete="surname"
                />

                <InputError class="mt-2" :message="form.errors.surname" />
            </div>

            <div>
                <InputLabel for="age" value="age" />

                <TextInput
                    id="age"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.age"
                    required
                    autofocus
                    autocomplete="age"
                />

                <InputError class="mt-2" :message="form.errors.age" />
            </div>

            <div>
                <InputLabel for="location" value="location" />

                <TextInput
                    id="location"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.location"
                    required
                    autofocus
                    autocomplete="location"
                />

                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div>
                <InputLabel for="photos" value="photos" />

                <TextInput
                    id="photos"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.photos"
                    required
                    autofocus
                    autocomplete="photos"
                />

                <InputError class="mt-2" :message="form.errors.photos" />
            </div>

            <div>
                <InputLabel for="social_media" value="social media:" />

                <TextInput
                    id="social_media"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.social_media"
                    required
                    autofocus
                    autocomplete="social_media"
                />

                <InputError class="mt-2" :message="form.errors.social_media" />
            </div>

            <div>
                <InputLabel for="interests" value="interests" />

                <TextInput
                    id="finterests"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.interests"
                    required
                    autofocus
                    autocomplete="interests"
                />

                <InputError class="mt-2" :message="form.errors.interests" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
