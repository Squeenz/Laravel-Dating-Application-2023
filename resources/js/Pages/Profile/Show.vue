<script setup>
import { reactive } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ShieldAlert, X, ShieldEllipsis } from 'lucide-vue-next';
import { usePermissions } from '@/Composables/usePermissions';

const { hasPerm } = usePermissions();

const props = defineProps({
    userData: Object,
    userPhotos: Object,
    canReport: Boolean,
});

const options = [
  'Harassment',
  'Inappropriate Behavior',
  'Impersonation',
  'Scam or Fraud',
  'Suspicious Activity',
  'Stalking or Obsessive Behavior',
  'Discrimination or Hate Speech',
  'Privacy Violation',
];

const page = usePage();
const urlUserID = page.url.split('/')[2];

const form = useForm({
    suspect: urlUserID,
    complainant: page.props.auth.user.id,
    violated_rule: '',
    extra_information: '',
})

const states = reactive({
    reportMenu: false,
})

const toggleReportMenu = () =>
{
    states.reportMenu = !states.reportMenu;
    states.reportMenu ? document.documentElement.style.overflow = 'hidden' : document.documentElement.style.overflow = 'auto';
}
</script>

<template>
  <div>
    <Head :title="userData.username" />

    <Transition name="fade">
        <div
            v-if="states.reportMenu"
            class="absolute inset-0 w-full bg-[#000000eb] p-[7rem] min-h-[200%]">
            <X class="text-red-600 float-right" @click="toggleReportMenu"/>
            <section class="m-[1em] text-center">
                <h1 class="text-2xl text-red-600">Report Form</h1>
                <p class="text-orange-500">Are you sure you want to report this user?</p>
                <p class="text-gray-500">Not sure, read the guidelines (Click Here)</p>
            </section>

            <form @submit.prevent="form.post(route('report.store'), { onSuccess: () => { states.reportMenu = false; form.reset(); } })" class="bg-[#1A1A1A] p-[2rem] rounded-[0.2rem]">
                <InputLabel for="options" class="text-white my-2">Violated Rule:</InputLabel>
                <InputError :message="form.errors.violated_rule"/>
                <select
                    v-model="form.violated_rule"
                    name="options"
                    id="options"
                    class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm">
                    <option
                            v-for="incident in options"
                            class="text-black"
                            :key="incident"
                            :value="incident"
                        >
                        {{ incident }}
                    </option>
                </select>

                <InputLabel for="extra" class="text-white my-[1rem]">Information (Optional):</InputLabel>
                <InputError :message="form.errors.extra_information"/>
                <textarea
                    v-model="form.extra_information"
                    name="extra"
                    id="extra"
                    class="w-full text-black order-gray-300 focus:border-red-500 focus:ring-red-500 rounded-[0.2rem] shadow-sm resize-none h-[10rem]"></textarea>

                <PrimaryButton class="w-full justify-center mt-[1rem]">Report</PrimaryButton>
            </form>
        </div>
    </Transition>

    <AuthenticatedLayout>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="sm:py-[1rem] sm:px-[1rem] bg-[#0A0A0A] shadow rounded-sm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                    <div
                        v-if="page.props.auth.user.id != urlUserID && hasPerm('create report')"
                        class="float-right">
                        <PrimaryButton v-if="props.canReport" class="bg-red-500 text-center justify-center" @click="toggleReportMenu">report<ShieldAlert class="ml-[0.5rem]" :size="20"/></PrimaryButton>
                        <div v-else class="border-2 p-1 border-red-500 rounded-md bg-red-800 text-gray-200 text-center">
                            <ShieldEllipsis class="mx-auto" :size="50"/>
                            <h1>User already reported, </h1>
                            <p>Report is being processed</p>
                        </div>
                    </div>

                    <h1>{{ userData.first_name }} {{ userData.surname }} ({{ userData.username }})</h1>
                    <h1>Date of birth: {{ userData.dob }}</h1>
                    <h1>Location: {{ userData.location }}</h1>
                    <h1>Interests: {{ userData.interests }}</h1>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1>Photos</h1>
                <div class="bg-white shadow sm:rounded-sm w-full">
                    <div class="flex flex-wrap justify-center">
                        <img
                        v-for="photo in userPhotos"
                        class="h-[15rem] m-[0.1rem]"
                        :src="route('photos.get', photo.photo)"
                        :alt="userData.first_name + ' photo'"
                        :key="photo.id"
                        />
                    </div>
                </div>
            </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
