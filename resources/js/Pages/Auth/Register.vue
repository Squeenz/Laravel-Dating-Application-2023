<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const stage = ref(1);
const confirmInformationBox = ref(false);
const agreeWithPolicies = ref(false);

const genderOptions = ref(['Male','Female','Other']);

const form = useForm({
    username: '',
    first_name: '',
    surname: '',
    dob: '',
    gender: '',
    bio: '',
    email: '',
    location: '',
    password: '',
    password_confirmation: '',
});

const selectGender = (gender) => {
    form.gender = gender;
}

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};

//change the stage of the form
const changeStep = (direction) => {
    if (direction === 'next' && stage.value <= 4) {
        stage.value++;
    }
    else if (direction === 'prev'){
        stage.value--;
    }
}

//add an interest to the form input
const addInterest = (interest) => {
    //if the interest is not already in the form, add it, else remove it
    if (!form.interests.includes(interest)){
        form.interests += interest + ",";
    } else {
        form.interests = form.interests.replace(interest + ",", "");
    }
}

const dateOfBirthCheck = (dob) => {
    const currentDate = dayjs().format('YYYY/MM/DD').split('/');
    const dateOfBirth = dayjs(dob).format('YYYY/MM/DD').split('/');

    const currentYears = currentDate[0] - dateOfBirth[0];
    const currentMonth = currentDate[1] - dateOfBirth[1];
    const currentDay = currentDate[2] - dateOfBirth[2];

    const age = ((currentYears * 365) + (currentMonth * 31) + currentDay) / 365;

    const dateToCheck = dayjs(dob).format('YYYY/MM/DD');

    if (!dayjs(dateToCheck).isValid() || dateOfBirth[0] > dayjs().year())
    {
        form.setError("dob", "Invalid");
    }
    else if (age <= 18)
    {
        form.setError("dob", "You are too young");
    }
    else
    {
        return true;
    }

    return false;
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="w-full sm:max-w-3xl mt-6 px-6 py-4 bg-[#0A0A0A] shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <h1 class="text-[2rem] text-center text-white">Register</h1>
            <form @submit.prevent="submit" :key="stage" enctype="multipart/form-data">
                <div v-if="stage === 1">
                        <div>
                            <InputLabel class="text-white my-1" for="gender" value="Gender"/>
                            <InputError class="mt-2" :message="form.errors.gender"/>
                            <div class="flex">
                                <div
                                v-for="gender in genderOptions"
                                :key="gender"
                                class="m-2 mx-auto">
                                <button
                                    :class="{'bg-red-800': form.gender.includes(gender), 'bg-gray-900': !form.gender.includes(gender)}"
                                    class="px-[4rem] py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150"
                                    type="button"
                                    @click="selectGender(gender)"
                                    >
                                    {{ gender }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.bio"/>
                        <InputLabel class="text-white my-1" for="bio" value="Bio"/>
                        <TextInput
                            id="bio"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.bio"
                            autofocus
                            autocomplete="bio"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.username"/>
                        <InputLabel class="text-white my-1" for="username" value="Username"/>
                        <TextInput
                            id="username"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.username"
                            autofocus
                            autocomplete="username"
                        />
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="firstname" value="First name"/>
                        <InputError class="mt-2" :message="form.errors.first_name"/>
                        <TextInput
                            id="firstname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.first_name"
                            autofocus
                            autocomplete="firstname"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.surname"/>
                        <InputLabel class="text-white my-1" for="surname" value="Surname"/>
                        <TextInput
                            id="surname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.surname"
                            autofocus
                            autocomplete="surname"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.dob"/>
                        <InputLabel class="text-white my-1" for="dob" value="Date of birth"/>
                        <TextInput
                            id="dob"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.dob"
                            autofocus
                            autocomplete="dob"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.location"/>
                        <InputLabel  class="text-white my-1" for="location" value="Location"/>
                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            autofocus
                            autocomplete="location"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.email"/>
                        <InputLabel class="text-white my-1" for="email" value="Email"/>
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            autofocus
                            autocomplete="email"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.password" />
                        <InputLabel class="text-white my-1" for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            autocomplete="new-password"
                        />
                    </div>

                    <div>
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        <InputLabel class="text-white my-1" for="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            autocomplete="new-password"
                        />
                    </div>
                </div>


                <div v-if="stage === 2">
                    <div>
                        <h1 class="text-white">Profile Details</h1>
                        <div v-for="(value, field ) in form.data()" :key="field">
                            <InputError v-if="form.hasErrors" class="mt-2" :message="form.errors[field]"/>
                            <p v-if="field != 'password' && field != 'password_confirmation'" class="text-white">{{ field }}: {{ value }}</p>
                        </div>

                        <section class="text-center">
                            <checkbox id="confirmBox" @click="confirmInformationBox = !confirmInformationBox" v-model:checked="confirmInformationBox"/>
                            <label for="checkbox" class="text-red-600"> I confirm the details are correct</label>
                        </section>

                        <section class="text-center">
                            <checkbox id="confirmBox" @click="agreeWithPolicies = !agreeWithPolicies " v-model:checked="agreeWithPolicies "/>
                            <label for="checkbox" class="text-red-600"> I agree with the policies in place</label>
                            <a  class="text-white" :href="route('policies.index')" target="_blank"> (Click Here To Read)</a>
                        </section>
                    </div>
                </div>

                <div>
                    <div class="justify-end mt-4 grid-flow-col grid items-end">
                        <PrimaryButton v-if="stage != 1" class="ms-4" :class="{ 'opacity-25': form.processing }" type="button" :disabled="form.processing" @click="changeStep('prev')">
                            Previous Step
                        </PrimaryButton>
                        <PrimaryButton v-if="stage != 2" class="ms-4" :class="{ 'opacity-25': form.processing }" type="button" :disabled="form.processing" @click="changeStep('next')">
                            Next Step
                        </PrimaryButton>
                        <PrimaryButton v-else class="ms-4" :class="{ 'opacity-25': !(confirmInformationBox && agreeWithPolicies) }" :disabled="!(confirmInformationBox && agreeWithPolicies)" :on-click="dateOfBirthCheck(form.dob)">
                            Register
                        </PrimaryButton>
                    </div>
                    <Link
                        :href="route('login')"
                        class="float-right mt-4 underline text-sm text-red-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                        Already registered?
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
