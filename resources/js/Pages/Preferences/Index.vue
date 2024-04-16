<script setup>
import { ref, onMounted, watch, reactive,  } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Heart, HeartCrack, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    allOptions: Object,
});

const minAge = ref('18');
const maxAge = ref('60');

const form = useForm({
    gender: '',
    age_range: minAge.value + ',' + maxAge.value,
    smoking_status: '',
    drinking_habits: '',
    body_type: '',
    exercise_frequency: '',
    pets: '',
    dietary: '',
    languages_spoken: '',
    has_children: '',
    wants_children: '',
    education_level: '',
    occupation: '',
    height: '',
    ethnicity: '',
    religion: '',
});

const sectionTitles = [];
const sectionOptions = [];

for (const key in props.allOptions) {
    if (Object.hasOwnProperty.call(props.allOptions, key)) {
        sectionTitles.push(key); // Push the title (key)
        sectionOptions.push(props.allOptions[key]); // Push the values
    }
}

// Modify sectionTitles array to capitalize words separated by underscores
const modifiedTitles = sectionTitles.map((title, index) => {
    if (title.includes('_')) {
        return title.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    } else {
        return title.charAt(0).toUpperCase() + title.slice(1); // Capitalize first letter if no underscores
    }
});

const selectedItem = (fieldName, option, type) => {
    if (type === false && form[fieldName] === option) {
        form[fieldName] = ''; // Reset to empty string if the same option is clicked again
    } else if (type !== false) {
        const optionsArray = form[fieldName].split(',');
        const optionIndex = optionsArray.indexOf(option);
        if (optionIndex !== -1) {
            optionsArray.splice(optionIndex, 1); // Remove the option from the array
            form[fieldName] = optionsArray.join(','); // Join the remaining options back into a string
        } else {
            form[fieldName] += (form[fieldName] ? ',' : '') + option; // Add the option if it's not already present
        }
    } else {
        form[fieldName] = option;
    }
};
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

            <form @submit.prevent="form.post(route('preferences.store'))">
                <div class="m-2 rounded-sm p-6 bg-red-900">
                    <InputLabel class="text-white my-1" for="age_range_preference" value="Age"/>
                    <h1 class="text-white">Min: {{ minAge }}</h1>
                    <TextInput class="accent-gray-500 h-2 w-full" type="range" min="18" :max="maxAge + 1" v-model="minAge" step="1"/>

                    <h1 class="text-white">Max: {{ maxAge }}</h1>
                    <TextInput type="range" class="accent-gray-500 h-2 w-full" :min="minAge" max="60" v-model="maxAge" step="1"/>
                </div>

                <div
                    v-for="(section, index) in modifiedTitles"
                    :key="section"
                    class="m-2">
                    <InputLabel class="text-white my-1" :for="section" :value="section"/>
                    <InputError v-if="form.hasErrors"  :message="form.errors[sectionTitles[index]]"/>
                    <div class="grid grid-cols-5 gap-2 text-cente">
                        <button v-for="option in sectionOptions[index].options"
                            :key="option"
                            :class="{'bg-red-800': form[sectionTitles[index]] != '' && form[sectionTitles[index]].includes(option), 'bg-gray-900': !form[sectionTitles[index]].includes(option)}"
                            class=" px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition ease-in-out duration-150"
                            type="button"
                            @click="selectedItem(sectionTitles[index], option, sectionOptions[index].multiple)"
                            >
                            {{ option }}
                        </button>
                    </div>
                </div>

                <PrimaryButton class="mt-2 flex justify-center w-full">submit</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
  </div>
</template>
