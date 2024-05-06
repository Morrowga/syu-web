<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ActiveButton from '@/Components/ActiveButton.vue';
import InActiveButton from '@/Components/InActiveButton.vue';
import MessageToast from '@/Components/MessageToast.vue';
import { router } from '@inertiajs/core';
import { ref, defineProps, computed, onMounted } from 'vue';
import { Link,usePage } from '@inertiajs/vue3';

const props = defineProps({
    defaultId :
    {
        required: true
    },
    defaultUrl:
    {
        type: String,
        required: true
    },
    default:
    {
        type: Number,
        required: true
    },
})


const setDefault = () => {
    router.post(props.defaultUrl + '/' + props.defaultId, {
        onSuccess: () => {
        },
    });
}
</script>
<template>
    <PrimaryButton class="rounded-3xl text-xs" @click="setDefault()" v-if="!props.default">
        Set Default
    </PrimaryButton>
    <VChip class="bg-green-500" v-else>
        Default
    </VChip>
  </template>
