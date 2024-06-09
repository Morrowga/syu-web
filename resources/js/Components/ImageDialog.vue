<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const dialog = ref(false);

defineProps({
    src: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: 'Title'
    },
    payment_method: {
        type: String,
        default: ''
    },
    paid_delviery_cost:{
        type: Boolean,
        default: false
    }
})

</script>

<template>
    <div>
        <PrimaryButton @click="dialog = true" class="my-2 text-sm">View Payment</PrimaryButton>

        <v-dialog
            v-model="dialog"
            width="auto"
        >
            <v-card
            width="600"
            max-width="400"
            prepend-icon="mdi-update"
            >
            <VCardText>
                <h1 class="font-bold text-xl">{{ title }}</h1>
            </VCardText>
            <VCardText class="my-1">
                <span>
                    Payment Method -
                    <span class="font-bold mx-5">{{ payment_method ?? '' }}</span>
                </span>
                <p :class="'font-bold text-capitalize my-3 ' +  (paid_delviery_cost == true ? 'text-[#4caf4f]' : 'text-[#c51162]')">{{ paid_delviery_cost ? 'Paid Delivery Fees' : 'Delivery Fees Not Included' }}</p>
            </VCardText>
            <VCardText>
                <VImg :src="src" cover/>
            </VCardText>
            <template v-slot:actions>
                <v-btn
                class="ms-auto"
                text="Ok"
                @click="dialog = false"
                ></v-btn>
            </template>
            </v-card>
        </v-dialog>
    </div>
</template>
