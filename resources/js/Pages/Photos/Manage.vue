<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Trash2, Pin, PinOff, ThumbsUp, ThumbsDown } from 'lucide-vue-next';

//define the prop to recieve the count of photos from the server
const props = defineProps({
    numberPhotos: Number,
    userPhotos: Object,
});

const updateState = ref(false);
const popUp = ref(false);
const imageInput = ref(null);

//we define the form as the inertiajs useForm method
//inside the form we define photo as an array since we are converitng the picture files
//into array and then appending to it.
const form = useForm({
    photo: []
});

//when the form calls the submit function we send a post http request to the photos.store route
//it will pass the from data automaticly.
const submit = () => {
    form.post(route('photos.store'),{
        onBefore: () => {
            popUp.value = true;
            setTimeout(() => {
                popUp.value = false;
            }, 1000);
            resetImageInput();
        },
        onSuccess: () => {
            form.photo = [];
            resetImageInput();
        },
    });
};

//Update the photo primary status, to know which profile pictures to use the main one.
const updatePhoto = (photo) => {
    if (!updateState.value)
    {
        updateState.value = true;
        router.patch(route('photos.update', { photo: photo }), {}, {
            onSuccess: () => {
                updateState.value = false;
            }
        });
    }
}

const destroyPhoto = (photo) => {
    if (!updateState.value)
    {
        updateState.value = true;
        router.delete(route('photos.destroy', photo.id), {
            onSuccess: () => {
                updateState.value = false;
            }
        });
    }
}

//when the function is called we will get the event file and append it to the photo field in the form
const handlePhoto = (event) => {
    form.photo = form.photo.concat(Array.from(event.target.files));
}

const resetImageInput = () => {
    // Reset the value of the input file element to null
    imageInput.value.value = '';
};
</script>

<template>
    <Head title="Add Photos" />

    <Transition name="pop-from-top">
        <div v-if="popUp" class="p-[2rem] w-full rounded-md text-white absolute border-b-2 z-50" :class=" { 'bg-green-600  border-green-700': form.photo.length !== 0, 'bg-red-600  border-red-700': form.photo.length === 0 }">
            <div v-if=" form.photo.length !== 0" class="flex justify-center">
                <ThumbsUp class="my-auto mr-[1rem]" :size="50"/>
                <h1 class="text-xl my-[1rem]">Photo added</h1>
            </div>
            <div v-else class="flex justify-center">
                <ThumbsDown class="my-auto mr-[1rem]" :size="50"/>
                <h1 class="text-xl my-[1rem]">No photo found</h1>
            </div>
        </div>
    </Transition>

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-[5rem] bg-[#0A0A0A] shadow rounded-sm text-white">
                    <div>
                        <h1 class="mx-[2rem] text-xl">Add photos to your profile</h1>
                        <h3 v-if="props.numberPhotos == 0"
                        class="text-center">
                        We have noticed you don't have any profile pictures
                        </h3>
                        <form @submit.prevent="submit" enctype="multipart/form-data" class="grid grid-flow-row w-full text-center">
                                <div class="sm:m-auto">
                                    <input ref="imageInput" class="ml-[8rem] my-[2rem]" type="file" @change="handlePhoto" accept="image/*" multiple>
                                </div>

                                <PrimaryButton
                                    class="w-[25rem] my-[2rem] m-auto justify-center"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Add Photos
                                </PrimaryButton>
                        </form>
                    </div>

                    <div>
                        <div v-if="numberPhotos !== 0">
                            <h1 class="mx-[2rem] text-xl">Manage your photos</h1>
                            <div class="flex flex-wrap justify-center">
                                <div v-for="photo in props.userPhotos" :key="photo.id" class="rounded-[0.1rem] mx-[1.7rem] m-[1rem] grid p-5" :class="{ 'rounded-xl bg-red-600': photo.primary === 1 }">
                                    <img
                                    class="h-[20rem] float-left"
                                    :src="route('photos.get', photo.photo)"
                                    :alt="photo.photo + ' photo'"
                                    draggable="false"
                                    />

                                    <div class="flex flex-wrap gap-2 justify-evenly rounded-b-md bg-gray-900 border-t-2 border-red-700">
                                        <PrimaryButton
                                            class="bg-gray-900"
                                            v-if="photo.primary != 1"
                                            @click="updatePhoto(photo)"
                                            >
                                            <Pin :size="20" class="text-red-600"/>
                                        </PrimaryButton>

                                        <PrimaryButton
                                            class="bg-gray-900"
                                            @click="destroyPhoto(photo)"
                                            >
                                            <Trash2 :size="20" class="text-red-600"/>
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.pop-from-top-enter-active {
    transition: all 0.3s ease-out;
}

.pop-from-top-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.pop-from-top-enter-from,
.pop-from-top-leave-to {
  transform: translateY(-50px);
  opacity: 0;
}

</style>
