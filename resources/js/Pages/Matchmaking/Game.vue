<script setup>
import { ref, onMounted, watch, reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Heart, HeartCrack, ChevronLeft, ChevronRight, Gauge, Cigarette, CigaretteOff, Wine, WineOff, GraduationCap, Briefcase, Palette, Home, Bird, FileBadge } from 'lucide-vue-next';

const props = defineProps(['user', 'potentialMatches', 'potentialMatchesPhotos']);

const listIndex = ref(0);
const currentPhotoIndex = ref(0);
const lengthImagesArray = ref(0);

const dislikeHovered = ref(false);
const dislikeClicked = ref(false);
const likeHovered = ref(false);
const likeClicked = ref(false);

const states = reactive({
    processing: false,
});

onMounted(() => {
  // Watch for changes in user data and potential matches
  watch([() => props.user, () => props.potentialMatches], () => {
    setUserIndexAndPhotoCount();
  });

  setUserIndexAndPhotoCount();
});

const setUserIndexAndPhotoCount = () => {
  currentPhotoIndex.value = 0;

  if (props.user.length !== 0 && props.potentialMatches[listIndex.value]) {
    const userId = props.potentialMatches[listIndex.value].user.information.id;

    // Check if potentialMatchesPhotos for the current user is available
    if (props.potentialMatchesPhotos[userId]) {
      lengthImagesArray.value = props.potentialMatchesPhotos[userId].length;
    } else {
      lengthImagesArray.value = 0;
    }
  } else {
    lengthImagesArray.value = 0;
  }
};

const changePicture = (direction) => {
  currentPhotoIndex.value += direction;

  if (currentPhotoIndex.value < 0) {
    currentPhotoIndex.value = 0;
  } else if (currentPhotoIndex.value === lengthImagesArray.value) {
    currentPhotoIndex.value = lengthImagesArray.value - 1;
  }
};

const reactToProfile = (status) => {
    status != 0 ? likeClicked.value = true: dislikeClicked.value = true;

    if (!states.processing){
        states.processing = true;
        router.post(route('like.store', status), {
            user_id: props.user.id,
            liked_user_id: props.potentialMatches[listIndex.value].user.information.id,
            is_like: status,
        }, {
            onSuccess: () => {
                states.processing = false;
                likeClicked.value = false;
                dislikeClicked.value = false;
            },
        });
    }
};
</script>

<template>
  <div>
    <Head title="Matchmaking" />
    <AuthenticatedLayout>
      <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="sm:py-[6.8rem] bg-[#0A0A0A] shadow rounded-sm">
            <div v-if="potentialMatches.length > 0" class="flex flex-wrap justify-center">
                <div @click="reactToProfile(0)" class="like my-auto mx-auto justify-center text-red-800 hover:text-red-600" @mouseover="dislikeHovered = true" @mouseleave="dislikeHovered = false" :class="{ 'hovered': dislikeHovered, 'click': dislikeClicked  }">
                    <HeartCrack :size="100"/>
                </div>

                <div class="rounded-md w-[35rem] text-white bg-gray-900 p-2">
                    <div class="text-white absolute grid gap-2 p-2">
                        <div class="bg-blue-500 p-2 rounded-md text-center">
                            <Gauge :size="30" class="mx-auto"/>
                            <h1>{{ potentialMatches[listIndex].user.scores.ageScore +  potentialMatches[listIndex].user.scores.attributeScore + potentialMatches[listIndex].user.scores.preferencesScore }}</h1>
                        </div>

                        <div class="bg-red-500 p-2 rounded-md text-center">
                            <CigaretteOff v-if="potentialMatches[listIndex].user.attributes[0].smoking_status === 'Non-smoker'" :size="30" class="mx-auto"/>
                            <Cigarette v-else :size="30" class="mx-auto"/>
                        </div>

                        <div class="bg-orange-500 p-2 rounded-md text-center">
                            <WineOff v-if="potentialMatches[listIndex].user.attributes[0].drinking_habits === 'Non-drinker'" :size="30" class="mx-auto"/>
                            <Wine v-else :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Student'" class="bg-green-500 p-2 rounded-md text-center" >
                            <GraduationCap :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Entrepreneur'" class="bg-green-500 p-2 rounded-md text-center" >
                            <Briefcase :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Professional'" class="bg-green-500 p-2 rounded-md text-center" >
                            <FileBadge :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Artist'" class="bg-green-500 p-2 rounded-md text-center" >
                            <Palette :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Homemaker'" class="bg-green-500 p-2 rounded-md text-center" >
                            <Home :size="30" class="mx-auto"/>
                        </div>

                        <div v-if="potentialMatches[listIndex].user.attributes[0].occupation === 'Retired'" class="bg-green-500 p-2 rounded-md text-center" >
                            <Bird  :size="30" class="mx-auto"/>
                        </div>

                    </div>


                    <div :key="potentialMatches[listIndex].user.information.id">
                        <img
                            :src="route('photos.get', potentialMatchesPhotos[potentialMatches[listIndex].user.information.id][currentPhotoIndex].photo)"
                            :alt="potentialMatches[listIndex].user.information.first_name + ' photo'"
                            class="m-auto"
                            draggable="false"
                            width="300"
                        >

                        <div class="grid grid-flow-col justify-between items-center text-center p-2">
                            <PrimaryButton @click="changePicture(-1)" class="justify-center w-[4rem]"> <ChevronLeft /> </PrimaryButton>
                            <h1>{{ currentPhotoIndex + 1 }} / {{ lengthImagesArray }} </h1>
                            <PrimaryButton @click="changePicture(1)" class="justify-center w-[4rem]"> <ChevronRight /> </PrimaryButton>
                        </div>

                        <div class="p-2 my-1 bg-gray-700 rounded-sm border-b-2 border-gray-300">
                            <h1>{{ potentialMatches[listIndex].user.information.first_name }} {{ potentialMatches[listIndex].user.information.surname }} ({{ potentialMatches[listIndex].user.information.username }})</h1>
                            <h1> Age: {{ potentialMatches[listIndex].user.age }}</h1>
                        </div>

                        <div  class="p-2 my-2 bg-gray-700 rounded-sm border-b-2 border-gray-300">
                            <h1 class="mb-2 border-b-2"> Movie Genres: </h1>
                            <h1> {{ potentialMatches[listIndex].user.attributes[0].movies_genres }} </h1>
                        </div>

                        <div class="p-2 my-2 bg-gray-700 rounded-sm border-b-2 border-gray-300">
                            <h1 class="mb-2 border-b-2"> Book Genres: </h1>
                            <h1>{{ potentialMatches[listIndex].user.attributes[0].books_genres }} </h1>
                        </div>
                    </div>
                </div>

                <div @click="reactToProfile(1)" class="like my-auto mx-auto justify-center text-red-800 hover:text-red-600" @mouseover="likeHovered = true" @mouseleave="likeHovered = false" :class="{ 'hovered': likeHovered, 'click': likeClicked }">
                    <Heart :size="100"/>
                </div>
            </div>
            <div v-else>
              <p class="text-white text-center">No potential matches found.</p>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<style>
.like {
  transition: all 0.5s ease;
}

@keyframes floatAndFade {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  50% {
    transform: translateY(-20px) scale(2.0);
    opacity: 0.8;
  }
  100% {
    transform: translateY(-40px) scale(3.0);
    opacity: 0;
  }
}

.hovered {
    transform: scale(1.5);
}

.click
{
    animation: floatAndFade 1.5s ease-out;
}
</style>
