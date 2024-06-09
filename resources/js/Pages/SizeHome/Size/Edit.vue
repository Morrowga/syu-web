<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'size']);

const form = useForm({
     name: props.size?.name,
     size: props.size?.size,
     price: props.size?.price,
     category_id: props.size?.category?.id,
     source_price: props.size?.source_price
});

const updateSize = () => {
    form.post(route('sizes.update', props.size?.id) + '?_method=PUT', {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};

</script>

<template>
    <Head :title="'Modify ' + props.size?.category?.name" class="capitalize" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify {{ props.size?.category?.name }} Size
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <VCard class="rounded-lg shadow-sm">
                    <VCardText>
                        <div class="my-10">
                            <VRow>
                                <VCol cols="6" offset="3">
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
                                        <div class="my-5">
                                            <InputLabel for="size" value="Size" :required="true" />
                                            <TextInput
                                                v-model="form.size"
                                                id="size"
                                                placeholder="Enter size"
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
                                                placeholder="Enter source price"
                                                id="source_price"
                                                type="number"
                                                oninput="this.value = Math.abs(this.value)"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.source_price" :message="errors.source_price" />
                                        </div>
                                        <div class="my-5 float-right">
                                            <Link :href="route('sizes.index', {category: props.size?.category?.id})">
                                                <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                            </Link>
                                            <PrimaryButton @click="updateSize" class="mx-2">Save</PrimaryButton>
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
