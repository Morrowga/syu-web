<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'shipping_city']);

const form = useForm({
     name_en: props.shipping_city?.name_en,
     name_mm: props.shipping_city?.name_mm,
     cost: props.shipping_city?.cost,
});

const updateShippingCity = () => {
    form.post(route('shipping-cities.update', props.shipping_city?.id) + '?_method=PUT', {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};

</script>

<template>
    <Head title="Modify Shipping City" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify Shipping City
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
                                            <InputLabel for="name_en" value="English Name" :required="true" />
                                            <TextInput
                                                v-model="form.name_en"
                                                id="name_en"
                                                type="text"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.name_en" :message="errors.name_en" />
                                        </div>
                                        <div class="my-5">
                                            <InputLabel for="name_mm" value="Myanmar Name" :required="true" />
                                            <TextInput
                                                v-model="form.name_mm"
                                                id="name_mm"
                                                type="text"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.name_mm" :message="errors.name_mm" />
                                        </div>
                                        <div class="my-5">
                                            <InputLabel for="cost" value="Cost" :required="true" />
                                            <TextInput
                                                v-model="form.cost"
                                                id="cost"
                                                type="number"
                                                class="mt-2 block w-full"
                                            />
                                            <FormError v-if="errors.cost" :message="errors.cost" />
                                        </div>
                                        <div class="my-5 float-right">
                                            <Link :href="route('shipping-cities.index')">
                                                <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                            </Link>
                                            <PrimaryButton @click="updateShippingCity" class="mx-2">Save</PrimaryButton>
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
