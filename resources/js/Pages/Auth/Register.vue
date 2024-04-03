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

let stage = ref(1);
let confirmBox = ref(false);

const interests = [
  "Hiking and nature",
  "Camping and stargazing",
  "Rock climbing",
  "Experimental cooking",
  "Foodie adventures",
  "Farmers' markets",
  "Yoga and meditation",
  "Running and marathons",
  "CrossFit",
  "Art galleries and museums",
  "Theater and musicals",
  "Painting and pottery",
  "Travel exploration",
  "Backpacking adventures",
  "Road trips",
  "Book club enthusiast",
  "Literary events",
  "Independent bookstores",
  "Concerts and festivals",
  "Learning music instruments",
  "Vinyl records",
  "Board games",
  "Video game marathons",
  "Gaming communities",
  "Community service",
  "Animal shelter volunteer",
  "Fundraising for causes",
  "Online courses",
  "Language exchange",
  "Science and tech events",
  "Live sports",
  "Recreational sports",
  "Fantasy sports leagues",
  "Sustainable living",
  "Upcycling and DIY",
];

const form = useForm({
    username: '',
    first_name: '',
    surname: '',
    dob: '',
    gender: '',
    bio: '',
    email: '',
    location: '',
    photos: '',
    interests: '',
    password: '',
    password_confirmation: '',
});

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
            <p class="text-center text-gray-200">Step {{ stage }} out of 3</p>
            <form @submit.prevent="submit" :key="stage" enctype="multipart/form-data">
                <div v-if="stage === 1">
                    <div>
                        <InputLabel class="text-white my-1" for="gender" value="Gender"/>
                        <TextInput
                            id="gender"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.gender"
                            autofocus
                            autocomplete="gender"
                        />
                        <InputError class="mt-2" :message="form.errors.gender"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="firstname" value="First name"/>
                        <TextInput
                            id="firstname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.first_name"
                            autofocus
                            autocomplete="firstname"
                        />
                        <InputError class="mt-2" :message="form.errors.first_name"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="surname" value="Surname"/>
                        <TextInput
                            id="surname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.surname"
                            autofocus
                            autocomplete="surname"
                        />
                        <InputError class="mt-2" :message="form.errors.surname"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="dob" value="Date of birth"/>
                        <TextInput
                            id="dob"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.dob"
                            autofocus
                            autocomplete="dob"
                        />
                        <InputError class="mt-2" :message="form.errors.dob"/>
                    </div>

                    <div>
                        <InputLabel  class="text-white my-1" for="location" value="Location"/>
                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            autofocus
                            autocomplete="location"
                        />
                        <InputError class="mt-2" :message="form.errors.location"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="email" value="Email"/>
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            autofocus
                            autocomplete="email"
                        />
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <div v-if="stage === 2">
                    <div>
                        <InputLabel class="text-white my-1" for="username" value="Username"/>
                        <TextInput
                            id="username"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.username"
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.username"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="bio" value="Bio"/>
                        <TextInput
                            id="bio"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.bio"
                            autofocus
                            autocomplete="bio"
                        />
                        <InputError class="mt-2" :message="form.errors.bio"/>
                    </div>

                    <div>
                        <InputLabel class="text-white my-1" for="interests" value="Interests"/>

                        <div class="grid grid-cols-5 gap-2 text-center">
                            <button v-for="n in interests"
                                :key="n"
                                :class="{'bg-red-800': form.interests.includes(n), 'bg-gray-900': !form.interests.includes(n)}"
                                class="items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150"
                                type="button"
                                @click="addInterest(n)"
                                >
                                {{ n }}
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="stage === 3">
                    <div>
                        <h1 class="text-white">Profile Details</h1>
                        <div v-for="(value, field ) in form.data()" :key="field">
                            <p v-if="field != 'password' && field != 'password_confirmation'" class="text-white">{{ field }}: {{ value }}</p>
                            <InputError v-if="form.hasErrors" class="mt-2" :message="form.errors[field]"/>
                        </div>


                    <!--<input type="checkbox" id="confirmBox" @click="confirmBox = !confirmBox" v-model="confirmBox"/> -->
                        <checkbox id="confirmBox" @click="confirmBox = !confirmBox" v-model:checked="confirmBox"/>
                        <label for="checkbox" class="text-red-600"> I confirm the details are correct</label>
                    </div>
                </div>

                <div>
                    <div class="justify-end mt-4 grid-flow-col grid items-end">
                        <PrimaryButton v-if="stage != 1" class="ms-4" :class="{ 'opacity-25': form.processing }" type="button" :disabled="form.processing" @click="changeStep('prev')">
                            Previous Step
                        </PrimaryButton>
                        <PrimaryButton v-if="stage != 3" class="ms-4" :class="{ 'opacity-25': form.processing }" type="button" :disabled="form.processing" @click="changeStep('next')">
                            Next Step
                        </PrimaryButton>
                        <PrimaryButton v-else class="ms-4" :class="{ 'opacity-25': !confirmBox }" :disabled=" !confirmBox" :on-click="dateOfBirthCheck(form.dob)">
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
