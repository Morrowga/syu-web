<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import IphoneCheckbox from '@/Components/IphoneCheckbox.vue';
import Datatable from '@/Components/Datatable.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['setting', 'errors', 'categories'])
const fileInput = ref(null);
const logoInput = ref(null);
const selectedFiles = ref([]);
const logImageUrl = ref(props.setting?.app_logo_img);
const oldImages = ref(props.setting?.images);

const bannerForm = useForm
({
    images: [],
    setting_type: 'banner',
    remove_images: []
})

const settingForm = useForm
({
     splash_slogan: props.setting?.splash_slogan,
     app_bg_color: props.setting?.app_bg_color,
     app_text_color: props.setting?.app_text_color,
     app_button_color: props.setting?.app_button_color,
     expire_day: props.setting?.expire_day,
     categories: [],
     app_logo_img: null,
     setting_type: 'general'
});

const openFileInput = () =>
{
    fileInput.value.click();
};

const handleFileChange = (event) =>
{
    const newFiles = Array.from(event.target.files).map(file => {
      const imageUrl = URL.createObjectURL(file);
      return { file, imageUrl };
    });
    bannerForm.images = [...bannerForm.images, ...newFiles.map(fileData => fileData.file)];
    selectedFiles.value = [...selectedFiles.value, ...newFiles.map(fileData => fileData.imageUrl)];
};

const removeImage = (index) =>
{
  selectedFiles.value.splice(index, 1);
  bannerForm.images.splice(index, 1);
};

const removeOldImage = (index,id) =>
{
  bannerForm.remove_images.push(id);
  oldImages.value.splice(index, 1);
};

const bannerSubmitEvent = () =>
{
    bannerForm.remove_images = JSON.stringify(bannerForm.remove_images);
    bannerForm.post(route('settings.update', props.setting?.id) + '?_method=PUT', {
        preserveScroll: true,
        onSuccess: () => {
            oldImages.value = props.setting?.images
            bannerForm.reset();
            selectedFiles.value = [];
        },
        onError: (error) => {
        },
    })
}

const generalSubmitEvent = () =>
{
    settingForm.categories = JSON.stringify(props.categories);
    console.log(settingForm)
    settingForm.post(route('settings.update', props.setting?.id) + '?_method=PUT', {
        preserveScroll: true,
        onSuccess: () => {
            settingForm.categories = props.categories;
        },
        onError: (error) => {
        },
    })
}

const openLogoInput = () => {
    logoInput.value.click();
}


const handleLogoUpload = (event) => {
    const file = event.target.files[0];
      if (file) {
        logImageUrl.value = URL.createObjectURL(file);
        settingForm.app_logo_img = file
      }
}

</script>

<template>
    <Head title="Setting" />


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="gears" />
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="bg-white shadow-none rounded-lg">
                    <form @submit.prevent="generalSubmitEvent" class="space-y-6">
                        <VCardText>
                            <h2 ref="sectionTitle" class="text-lg font-medium text-gray-900 p-4">
                                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="gear" />
                                General
                            </h2>
                            <VRow>
                                <VCol cols="7">
                                    <VRow class="p-4">
                                        <VCol cols="4" v-for="category in props.categories" :key="category.id">
                                            <div class="my-3">
                                                <IphoneCheckbox v-model="category.is_active" :id="category.name" :title="category.name" />
                                                <div class="my-5">
                                                    <InputLabel for="waiting_days" :value="category.name + ' Waiting Days'" :required="true" />
                                                    <TextInput
                                                        v-model="category.waiting_days"
                                                        placeholder="Enter waiting days"
                                                        id="waitingdays"
                                                        type="number"
                                                        oninput="this.value = Math.abs(this.value)"
                                                        class="mt-2 block w-full"
                                                    />
                                                </div>
                                                <div class="my-5">
                                                    <InputLabel for="limitation" :value="category.name + ' Limitation'" :required="true" />
                                                    <TextInput
                                                        v-model="category.limitation"
                                                        placeholder="Enter Limitation"
                                                        id="limitation"
                                                        type="number"
                                                        oninput="this.value = Math.abs(this.value)"
                                                        class="mt-2 block w-full"
                                                    />
                                                </div>
                                            </div>
                                        </VCol>
                                        <!-- <VCol cols="4">
                                            <div class="my-3">
                                                <IphoneCheckbox v-model="settingForm.is_badge_active" id="badge" title="Badge"/>
                                            </div>
                                        </VCol>
                                        <VCol cols="4">
                                            <div class="my-3">
                                                <IphoneCheckbox v-model="settingForm.is_poster_active" id="poster" title="Poster" />
                                            </div>
                                        </VCol> -->
                                        <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="app_bg_color" value="App Background Color" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.app_bg_color"
                                                    placeholder="Enter app bg color"
                                                    id="appbgcolor"
                                                    type="text"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.app_bg_color" :message="errors.app_bg_color" />
                                            </div>
                                        </VCol>
                                        <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="app_text_color" value="App Text Color" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.app_text_color"
                                                    placeholder="Enter app text color"
                                                    id="apptextcolor"
                                                    type="text"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.app_text_color" :message="errors.app_text_color" />
                                            </div>
                                        </VCol>
                                        <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="app_button_color" value="App Button Color" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.app_button_color"
                                                    placeholder="Enter app button color"
                                                    id="appbuttoncolor"
                                                    type="text"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.app_button_color" :message="errors.app_button_color" />
                                            </div>
                                        </VCol>
                                        <!-- <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="waiting_days" value="Waiting Days" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.waiting_days"
                                                    placeholder="Enter waiting days"
                                                    id="waitingdays"
                                                    type="number"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.waiting_days" :message="errors.waiting_days" />
                                            </div>
                                        </VCol> -->
                                        <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="splash_slogan" value="Splash Slogan" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.splash_slogan"
                                                    placeholder="Enter splash slogan"
                                                    id="splashslogan"
                                                    type="text"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.splash_slogan" :message="errors.splash_slogan" />
                                            </div>
                                        </VCol>
                                        <VCol cols="4">
                                            <div class="my-2">
                                                <InputLabel for="expire_day" value="Order Expire Day" :required="true" />
                                                <TextInput
                                                    v-model="settingForm.expire_day"
                                                    placeholder="Enter expire day"
                                                    id="expire_day"
                                                    type="text"
                                                    class="mt-2 block w-full"
                                                />
                                                <FormError v-if="errors.expire_day" :message="errors.expire_day" />
                                            </div>
                                        </VCol>
                                    </VRow>
                                </VCol>
                                <VCol cols="5">
                                    <div class="my-2">
                                        <div  @click="openLogoInput"  class="h-[50vh] flex justify-center  items-center bg-white rounded-lg shadow-md p-6 border-dashed border-2 border-gray-300 hover:border-gray-400 cursor-pointer">
                                            <VImg :src="logImageUrl" v-if="logImageUrl != null" cover></VImg>
                                            <div v-else>
                                                <p class="text-sm text-gray-500">Click to browse.</p>
                                            </div>
                                        </div>
                                        <FormError v-if="errors.logo_img" :message="errors.logo_img" />
                                        <input type="file" ref="logoInput" id="logoInput" class="hidden" @change="handleLogoUpload">
                                    </div>
                                </VCol>
                            </VRow>
                            <div class="flex items-center gap-4 float-right my-4 p-4">
                                <PrimaryButton :disabled="settingForm.processing">Save</PrimaryButton>
                            </div>
                        </VCardText>
                    </form>
                </VCard>
                <VCard class="bg-white shadow-none rounded-lg my-3">
                    <VCardText>
                            <h2  ref="sectionTitle" class="text-lg font-medium text-gray-900 pa-4">
                                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="panorama" />
                                Banners
                            </h2>
                            <VRow class="pa-4">
                                <VCol cols="4" v-for="(url, index) in oldImages" :key="index">
                                    <div class="relative h-[25vh] my-4 bg-white rounded-lg shadow-md p-6 border-dashed border-2 border-gray-300 hover:border-gray-400 cursor-pointer">
                                        <div class="absolute top-[-17px] right-[-13px] m-2">
                                            <FontAwesomeIcon @click="removeOldImage(index, url.id)" class="text-red-500 text-lg" icon="circle-xmark" />
                                        </div>
                                        <VImg :src="url.image" cover></VImg>
                                    </div>
                                </VCol>
                                <VCol cols="4" v-for="(url, index) in selectedFiles" :key="index">
                                    <div class="relative h-[25vh] my-4 bg-white rounded-lg shadow-md p-6 border-dashed border-2 border-gray-300 hover:border-gray-400 cursor-pointer">
                                        <div class="absolute top-[-17px] right-[-13px] m-2">
                                            <FontAwesomeIcon @click="removeImage(index)" class="text-red-500 text-lg" icon="circle-xmark" />
                                        </div>
                                        <VImg :src="url" cover></VImg>
                                    </div>
                                </VCol>
                                <VCol cols="4">
                                    <div  @click="openFileInput"  class="h-[25vh] my-4 flex justify-center  items-center bg-white rounded-lg shadow-md p-6 border-dashed border-2 border-gray-300 hover:border-gray-400 cursor-pointer">
                                        <div>
                                            <FontAwesomeIcon class="text-gray-400 text-lg" icon="circle-plus" />
                                        </div>
                                    </div>
                                </VCol>
                            </VRow>
                            <input type="file" ref="fileInput" multiple id="fileInput" class="hidden" @change="handleFileChange">
                            <div class="flex items-center gap-4 float-right my-4 p-4">
                                <PrimaryButton @click="bannerSubmitEvent" :disabled="bannerForm.processing">Save</PrimaryButton>
                            </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
        <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
        >
            <div
            class="fixed z-10 bottom-0 left-0 mb-4 mx-5 p-4 bg-gray-800 text-white rounded shadow"
            v-if="bannerForm.recentlySuccessful"
            >
                <span class="px-3">
                    <FontAwesomeIcon class="text-green-500 mr-2"  icon="circle-check" />
                    Banner updated
                </span>
            </div>
        </Transition>
        <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
        >
        <div
            class="fixed z-10 bottom-0 left-0 mb-4 mx-5 p-4 bg-gray-800 text-white rounded shadow"
            v-if="settingForm.recentlySuccessful"
            >
                <span class="px-3">
                    <FontAwesomeIcon class="text-green-500 mr-2"  icon="circle-check" />
                    Setting updated
                </span>
            </div>
        </Transition>
    </AuthenticatedLayout>
</template>
