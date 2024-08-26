<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'category']);

const form = useForm({
     name: "",
     size: '',
     price: 0,
     category_id: props.category?.id,
     source_price: 0,
});
const saveSize = () => {
    form.post(route('sizes.store'), {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};
</script>

<template>
    <Head :title="props.category?.name + ' Creation'" class="capitalize" style="text-transform: capitalize;" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="folder-plus" />
                {{ props.category?.name }} Size Creation
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <div class="my-10">
                            <VRow>
                                <VCol cols="4" offset="4">
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
                                        <div class="my-5">
                                            <InputLabel for="size" value="Size" :required="true" />
                                            <TextInput
                                                v-model="form.size"
                                                placeholder="Enter size"
                                                id="size"
                                                type="text"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.size" :message="errors.size" />
                                        </div>
                                        <div class="my-5">
                                            <InputLabel for="price" value="Price" :required="true" />
                                            <TextInput
                                                v-model="form.price"
                                                placeholder="Enter price"
                                                id="price"
                                                type="number"
                                                oninput="this.value = Math.abs(this.value)"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.price" :message="errors.price" />
                                        </div>
                                        <div class="my-5">
                                            <InputLabel for="source_price" value="Source Price" :required="true" />
                                            <TextInput
                                                v-model="form.source_price"
                                                placeholder="Enter Source Price"
                                                id="source_price"
                                                type="number"
                                                oninput="this.value = Math.abs(this.value)"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.source_price" :message="errors.source_price" />
                                        </div>
                                        <div class="my-5 float-right">
                                            <Link :href="route('sizes.index', {category: props.category?.id})">
                                                <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                            </Link>
                                            <PrimaryButton @click="saveSize" class="mx-2">Save</PrimaryButton>
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
