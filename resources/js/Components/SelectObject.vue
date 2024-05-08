<script setup>
import { onMounted, ref, defineProps } from 'vue';

const model = defineModel
(
    {
        type: String,
        required: true,
    }
);

const props = defineProps({
    items:
    {
        type: Object,
        required: true
    }
})

const input = ref(null);

</script>

<template>

    <select
        v-model="model"
        class="w-full inline-flex items-center px-4 py-2 my-4 bg-white border border-transparent rounded-md font-semibold text-sm text-black uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <option selected>Select City</option>
       <option v-for="(item,index) in items" :key="index" :value="item.id">{{ item.name_en }}</option>
    </select>

</template>
