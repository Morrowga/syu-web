<script setup>
import { ref, defineProps } from 'vue';

const model = defineModel
(
    {
        type: Boolean,
        required: true,
    }
);

const props = defineProps({
    id:
    {
        type: String,
        required: true
    },
    title:
    {
        type: String,
        required: true
    }
})

</script>

<template>

  <input type="checkbox" v-model="model" :value="model" class="ios8-switch ios8-switch-lg" :id="props.id">
  <label class="font-bold text-sm text-gray-700 capitalize" :for="props.id">{{ props.title  }}</label>

</template>

<style scoped>

input[type="checkbox"].ios8-switch {
    position: absolute;
    margin: 8px 0 0 16px;
}
input[type="checkbox"].ios8-switch + label {
    position: relative;
    padding: 5px 0 0 50px;
    line-height: 2.0em;
}

input[type="checkbox"].ios8-switch + label:before {
    content: "";
    position: absolute;
    display: block;
    left: 0;
    top: 0;
    width: 40px;
    height: 24px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #d9d9d9;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
input[type="checkbox"].ios8-switch + label:after {
    content: "";
    position: absolute;
    display: block;
    left: 0px;
    top: 0px;
    width: 24px;
    height: 24px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #d9d9d9;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
input[type="checkbox"].ios8-switch + label:hover:after {
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
}
input[type="checkbox"].ios8-switch:checked + label:after {
    margin-left: 16px;
}
input[type="checkbox"].ios8-switch:checked + label:before {
    background: #55D069;
}

input[type="checkbox"].ios8-switch-lg {
    margin: 10px 0 0 20px;
}
input[type="checkbox"].ios8-switch-lg + label {
    position: relative;
    padding: 7px 0 0 60px;
    line-height: 2.3em;
}
input[type="checkbox"].ios8-switch-lg + label:before {
    width: 50px;
    height: 30px;
    border-radius: 20px;
}
input[type="checkbox"].ios8-switch-lg + label:after {
    width: 30px;
    height: 30px;
    border-radius: 20px;
}
input[type="checkbox"].ios8-switch-lg + label:hover:after {
    box-shadow: 0 0 8px rgba(0,0,0,0.3);
}
input[type="checkbox"].ios8-switch-lg:checked + label:after {
    margin-left: 20px;
}


</style>
