<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectArray from '@/Components/SelectArray.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FormError from '@/Components/FormError.vue';
import { ref, defineProps } from 'vue';

const props = defineProps(['errors', 'user']);

const imageUrl = ref(props.user?.avatar);

const form = useForm({
     name: props.user?.name,
     email: props.user?.email,
     msisdn: props.user?.msisdn,
     city: props.user?.city,
     shipping_address: props.user?.shipping_address,
     gender: props.user?.gender,
});

const updateUser = () => {
    form.post(route('users.update', props.user?.id) + '?_method=PUT', {
        onSuccess: () => {
        },
        onError: (error) => {
        },
    });
};
</script>

<template>
    <Head title="'Modify User" class="capitalize" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <FontAwesomeIcon class="text-gray-500 text-lg mr-2" icon="scissors" />
                Modify User
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
                                                <div class="my-5">
                                                    <InputLabel for="email" value="Email"/>
                                                    <TextInput
                                                        v-model="form.email"
                                                        id="email"
                                                        type="email"
                                                        class="mt-2 block w-full"
                                                    />
                                                </div>
                                                <div class="my-5">
                                                    <InputLabel for="msisdn" value="Phone" :required="true" />
                                                    <TextInput
                                                        v-model="form.msisdn"
                                                        id="msisdn"
                                                        type="number"
                                                        oninput="this.value = Math.abs(this.value)"
                                                        class="mt-2 block w-full"
                                                    />
                                                    <FormError v-if="errors.msisdn" :message="errors.msisdn" />
                                                </div>
                                                <div class="my-5">
                                                    <InputLabel for="city" value="City" />
                                                    <TextInput
                                                        v-model="form.city"
                                                        id="city"
                                                        type="text"
                                                        class="mt-2 block w-full"
                                                    />
                                                </div>
                                                <div class="my-5">
                                                    <InputLabel for="shipping_address" value="Shipping Address" />
                                                    <TextInput
                                                        v-model="form.shipping_address"
                                                        id="shipping_address"
                                                        type="text"
                                                        class="mt-2 block w-full"
                                                    />
                                                </div>
                                                <div class="my-5">
                                                    <InputLabel for="gender" value="Gender" />
                                                    <SelectArray v-model="form.gender" :items="['male', 'female', 'other']" />
                                                    <!-- <TextInput
                                                        v-model="form.shipping_address"
                                                        id="shipping_address"
                                                        type="text"
                                                        class="mt-2 block w-full"
                                                    /> -->
                                                </div>
                                                <div class="my-5 float-right">
                                                    <Link :href="route('users.index')">
                                                        <PrimaryButton class="mx-2">Cancel</PrimaryButton>
                                                    </Link>
                                                    <PrimaryButton @click="updateUser" class="mx-2">Save</PrimaryButton>
                                                </div>
                                            </div>
                                        </VCol>
                                        <VCol cols="6">
                                            <div class="flex justify-center mt-10">
                                                <div>
                                                    <VImg :src="imageUrl" class="rounded-full" v-if="imageUrl != null" width="200" height="200"></VImg>
                                                </div>
                                            </div>
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
