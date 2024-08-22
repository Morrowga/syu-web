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
    transaction: {
        type: Array,
        default: []
    },
    paid_delviery_cost:{
        type: Boolean,
        default: false
    }
})

function formatDate(date) {
  const options = {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  };

  return new Date(date).toLocaleString('en-US', options);
}

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
            <template v-slot:title>
                <div class="my-5">
                    <span class="font-weight-black">{{ title }}</span>
                </div>
            </template>
            <VCardText class="rounded-full">
                <VCardText class="bg-surface-light">
                    <span>
                        Payment Method
                    </span>
                    <div class="font-bold mx-2 my-1">
                        <span>
                            {{ transaction?.payment_method ?? '' }}
                        </span>
                    </div>
                </VCardText>
                <VCardText class="bg-surface-light">
                    <span>
                        Delivery Fees
                    </span>
                    <div class="font-bold mx-2 my-1">
                        <span>
                            {{ paid_delviery_cost ? 'Paid' : 'No Paid' }}
                        </span>
                    </div>
                </VCardText>
                <VCardText class="bg-surface-light">
                    <span>
                        Account Name
                    </span>
                    <div class="font-bold mx-2 my-1">
                        <span>
                            {{ transaction?.account_name }}
                        </span>
                    </div>
                </VCardText>
                <VCardText class="bg-surface-light">
                    <span>
                        Transaction Id / No
                    </span>
                    <div class="font-bold mx-2 my-1">
                        <span>
                            {{ transaction?.transaction_id }}
                        </span>
                    </div>
                </VCardText>
                <VCardText class="bg-surface-light">
                    <span>
                        Paid Date
                    </span>
                    <div class="font-bold mx-2 my-1">
                        <span>
                            {{ formatDate(transaction?.created_at) }}
                        </span>
                    </div>
                </VCardText>
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
