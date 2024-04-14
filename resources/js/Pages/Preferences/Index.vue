<script setup>
import { ref, onMounted, watch, reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Heart, HeartCrack, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const stage = ref(1);

const rangeValues = ref({
   age:{
        min: 18,
        max: 60,
   },
   locationDistance: 0,
});

const selectedInterests = ref([]);
const selectedPersonalityTraits = ref([]);

const genders = ref([
    'Male',
    'Female',
    'Other',
]);

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

const personalityTraits = [
    "Outgoing",
    "Introverted",
    "Ambitious",
    "Easygoing",
    "Adventurous",
    "Spontaneous",
    "Intellectual",
    "Creative",
    "Humorous",
    "Optimistic",
    "Pessimistic",
    "Caring",
    "Compassionate",
    "Empathetic",
    "Analytical",
    "Practical",
    "Emotional",
    "Rational",
    "Confident",
    "Insecure",
    "Assertive",
    "Passive",
    "Independent",
    "Dependent",
    "Sociable",
    "Reserved",
    "Sensible",
    "Sensual",
    "Traditional",
    "Open-minded",
    "Liberal",
    "Conservative",
    "Risk-taker",
    "Risk-averse",
    "Ambiverted",
    "Assertive",
    "Passive",
    "Friendly",
    "Warm",
    "Cold",
    "Generous",
    "Stingy",
    "Trusting",
    "Skeptical",
    "Patient",
    "Impatient",
    "Reliable",
    "Unreliable"
];


const addInterest = (n) => {
    if (!selectedInterests.value.includes(n)){
        selectedInterests.value.push(n);
    } else {
        selectedInterests.value.splice(selectedInterests.value.indexOf(n), 1);
    }
}

const addPersonalityTrait = (n) => {
    if (!selectedPersonalityTraits.value.includes(n)){
        selectedPersonalityTraits.value.push(n);
    } else {
        selectedPersonalityTraits.value.splice(selectedPersonalityTraits.value.indexOf(n), 1);
    }
}
</script>

<template>
  <div>
    <Head title="Preferences" />
    <AuthenticatedLayout>
        <div class="w-full sm:max-w-3xl mt-6 px-6 py-4 bg-[#0A0A0A] shadow-md overflow-hidden sm:rounded-lg mx-auto">
            <div class="m-2">
                <p class="text-2xl text-center text-gray-200">Preferences</p>
                <p class="text-orange-400">What are you looking for?</p>
                <p class="text-gray-500">This will ensure we find the best matches for you</p>
            </div>

            <form @submit.prevent="submit" :key="stage">

                <div class="w-full flex justify-center">
                    <label v-for="gender in genders"
                        :key="gender"
                        class="p-1 rounded-sm m-[auto]">
                        <Checkbox name="remember"/>
                        <span class="m-1 text-white">{{ gender }}</span>
                    </label>
                </div>

                <div class="m-2 rounded-sm p-6 bg-red-900">
                    <InputLabel class="text-white my-1" for="age_range_preference" value="Age"/>
                    <h1 class="text-white">Min: {{ rangeValues.age.min }}</h1>
                    <TextInput class="accent-gray-500 h-2 w-full" type="range" min="18" :max="rangeValues.age.max - 1" v-model="rangeValues.age.min" step="1"/>

                    <h1 class="text-white">Max: {{ rangeValues.age.max }}</h1>
                    <TextInput type="range" class="accent-gray-500 h-2 w-full" :min="rangeValues.age.min" max="60" v-model="rangeValues.age.max" step="1"/>

                    <InputError class="mt-2" />
                </div>

                <div class="m-2 rounded-sm p-6 bg-red-900">

                    <InputLabel class="text-white my-1" for="location_preference" value="Maximum Distance for Matches"/>
                    <div class="relative mb-6">
                        <label for="labels-range-input" class="sr-only">Labels range</label>
                        <input id="labels-range-input" type="range" v-model="rangeValues.locationDistance" min="5" max="10000" class="accent-gray-500 w-full h-2 rounded-lg cursor-pointer">
                        <span class="text-sm text-white absolute start-0 -bottom-6">Min (5 miles)</span>
                        <span class="text-sm text-white absolute start-1/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6">50</span>
                        <span class="text-sm text-white absolute start-2/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6">100</span>
                        <span class="text-sm text-white absolute end-0 -bottom-6">Max (Any)</span>
                    </div>

                    <InputError class="mt-2" />
                </div>

                <div class="m-2">
                    <InputLabel class="text-white my-1" for="interests_hobbies_preference" value="Interests & Hobbies"/>
                    <!-- <TextInput
                        id="location_preference"
                        type="text"
                        class="mt-1 block w-full"

                        autofocus
                        autocomplete="location_preference"
                    /> -->
                    <div class="grid grid-cols-5 gap-2 text-cente">
                        <button v-for="n in interests"
                            :key="n"
                            :class="{'bg-red-800': selectedInterests.includes(n), 'bg-gray-900': !selectedInterests.includes(n)}"
                            class=" px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150"
                            type="button"
                            @click="addInterest(n)"
                            >
                            {{ n }}
                        </button>
                    </div>
                    <InputError class="mt-2" />
                </div>

                <div class="m-2">
                    <InputLabel class="text-white my-1" for="personality_traits_preference" value="Personality Traits"/>
                    <div class="grid grid-cols-5 gap-2 text-cente">
                        <button v-for="n in personalityTraits"
                            :key="n"
                            :class="{'bg-red-800': selectedPersonalityTraits.includes(n), 'bg-gray-900': !selectedPersonalityTraits.includes(n)}"
                            class=" px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150"
                            type="button"
                            @click="addPersonalityTrait(n)"
                            >
                            {{ n }}
                        </button>
                    </div>
                    <InputError class="mt-2" />
                </div>

                <PrimaryButton class="mt-2 flex justify-center w-full">submit</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
  </div>
</template>
