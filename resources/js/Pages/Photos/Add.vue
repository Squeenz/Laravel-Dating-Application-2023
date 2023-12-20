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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Photos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-[2rem] text-center">Add Photos</h1>
                    <p v-if="numberPhotos == 0"
                     class="text-center"
                     >
                     We have noticed you don't have any profile pictures
                    </p>
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div>
                            <div>
                                <InputLabel for="photos" value="Profile Photos"/>

                                <input class="mt-1 block w-full" type="file" @change="handlePhoto" accept="image/*" multiple>

                                <InputError class="mt-2" :message="form.errors.photos"/>
                            </div>
                        </div>

                        <div>
                            <div class="justify-end mt-4 grid-flow-col grid items-end">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Add Photos
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
