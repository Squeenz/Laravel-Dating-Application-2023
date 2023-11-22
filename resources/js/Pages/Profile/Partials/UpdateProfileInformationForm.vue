<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    username: user.username,
    first_name: user.first_name,
    surname: user.surname,
    gender: user.gender,
    age: user.age,
    bio: user.bio,
    interests: user.interests,
    location: user.location,
    social_media: user.social_media,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="username" value="Username" />

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
                <InputLabel for="first_name" value="First name" />

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
                <InputLabel for="surname" value="Surname" />

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
                <InputLabel for="age" value="Age" />

                <input
                    id="age"
                    type="number"
                    v-model="form.age"
                    required
                    autofocus
                    autocomplete="age"
                >

                <!-- <TextInput
                    id="age"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.age"
                    required
                    autofocus
                    autocomplete="age"
                /> -->

                <InputError class="mt-2" :message="form.errors.age" />
            </div>

            <div>
                <InputLabel for="gender" value="gender" />

                <TextInput
                    id="gender"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.gender"
                    required
                    autofocus
                    autocomplete="gender"
                />

                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <div>
                <InputLabel for="bio" value="bio" />

                <TextInput
                    id="bio"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.bio"
                    required
                    autofocus
                    autocomplete="bio"
                />

                <InputError class="mt-2" :message="form.errors.bio" />
            </div>

            <div>
                <InputLabel for="location" value="Location" />

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
                <InputLabel for="social_media" value="Social media" />

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
                <InputLabel for="interests" value="Interests" />

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

            <div>
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



            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
