<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

//define the prop to recieve the count of photos from the server
defineProps(['numberPhotos']);

//we define the form as the inertiajs useForm method
//inside the form we define photo as an array since we are converitng the picture files
//into array and then appending to it.
const form = useForm({
    photo: []
});

//when the form calls the submit function we send a post http request to the photos.store route
//it will pass the from data automaticly.
const submit = () =>{
    form.post(route('photos.store'),{
        onSubmit: () => form.reset('photo'),
    });
}

//when the function is called we will get the event file and append it to the photo field in the form
const handlePhoto = (event) => {
    form.photo = form.photo.concat(Array.from(event.target.files));
}
</script>

<template>
    <Head title="Add Photos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Add Photos
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:h-[51.3rem] sm:py-[20rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <h3 v-if="numberPhotos == 0"
                     class="text-center">
                     We have noticed you don't have any profile pictures
                    </h3>
                    <form @submit.prevent="submit" enctype="multipart/form-data" class="grid grid-flow-row w-full text-center">
                            <div class="sm:m-auto">
                                <InputLabel v-if="numberPhotos != 0" for="photos" value="Select Profile Photos To Add" class="text-white"/>
                                <input class="ml-[8rem] my-[2rem] " type="file" @change="handlePhoto" accept="image/*" multiple>
                            </div>

                            <PrimaryButton
                                class="w-[25rem] my-[2rem] m-auto justify-center"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Add Photos
                            </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
