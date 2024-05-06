<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'product']);

const fileInput = ref(null);

const imageUrl = ref(props.product?.image_url);

const form = useForm({
     name: props.product?.name,
     image: null,
     category_id: props.product?.category_id
});

const openFileInput = () => {
    fileInput.value.click();
}

const updateProduct = () => {
    form.post(route('products.update', props.product?.id) + '?_method=PUT', {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
      if (file) {
        imageUrl.value = URL.createObjectURL(file);
        form.image = file
      }
}

</script>

<template>
    <Head :title="'Modify ' + props.product?.category?.name" class="capitalize" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify {{ props.product?.category?.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <div class="my-10">
                            <VRow>
                                <VCol cols="8" offset="2">
                                    <VRow>
                                        <VCol cols="6">
                                            <div>
                                                <div class="my-5">
                                                    <InputLabel for="name" value="Name" :required="true" />
                                                    <TextInput
                                                        v-model="form.name"
                                                        id="name"
                                                        type="text"
                                                        class="mt-2 block w-full"
                                                    />
                                                    <FormError v-if="errors.name" :message="errors.name" />
                                                </div>
                                                <div class="my-5 float-right">
                                                    <Link :href="route('products.index', {category: props.product?.category_id})">
                                                        <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                                    </Link>
                                                    <PrimaryButton @click="updateProduct" class="mx-2">Save</PrimaryButton>
                                                    <!-- <PrimaryButton class="mx-2" @click="saveSticker(1)">Save & Continue</PrimaryButton> -->
                                                </div>
                                            </div>
                                        </VCol>
                                        <VCol cols="6">
                                            <div  @click="openFileInput"  class="h-[50vh] flex justify-center  items-center bg-white rounded-lg shadow-md p-6 border-dashed border-2 border-gray-300 hover:border-gray-400 cursor-pointer">
                                                <VImg :src="imageUrl" v-if="imageUrl != null" cover></VImg>
                                                <div v-else>
                                                    <p class="text-sm text-gray-500">Click to browse.</p>
                                                </div>
                                            </div>
                                            <FormError v-if="errors.image" :message="errors.image" />
                                            <input type="file" ref="fileInput" id="fileInput" class="hidden" @change="handleFileUpload">
                                        </VCol>
                                    </VRow>
                                </VCol>

                            </VRow>
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
