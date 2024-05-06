<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors']);

const form = useForm({
     name: "",
});

const saveCategory = () => {
    form.post(route('categories.store'), {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};

</script>

<template>
    <Head title="Category Creation" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="folder-plus" />
                Category Creation
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <div class="my-10">
                            <VRow>
                                <VCol cols="8" offset="2">
                                    <div>
                                        <div class="my-5">
                                            <InputLabel for="name" value="Name" :required="true" />
                                            <TextInput
                                                v-model="form.name"
                                                placeholder="Enter name"
                                                id="name"
                                                type="text"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.name" :message="errors.name" />
                                        </div>
                                        <div class="my-5 float-right">
                                            <Link :href="route('categories.index')">
                                                <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                            </Link>
                                            <PrimaryButton @click="saveCategory" class="mx-2">Save</PrimaryButton>
                                            <!-- <PrimaryButton class="mx-2" @click="saveSticker(1)">Save & Continue</PrimaryButton> -->
                                        </div>
                                    </div>
                                </VCol>
                            </VRow>
                        </div>
                    </VCardText>
                </VCard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
