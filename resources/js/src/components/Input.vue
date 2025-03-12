<script lang="ts" setup>
defineProps<{
    type?: string;
    placeholder?: string;
    customClass?: {
        type: string,
        default: ''
    };
    modelValue: string;
}>();

const emit=defineEmits<{
    (e:'update:modelValue',val:any):void
}>()

function updateValue(event:any){
    const val=event.target.value
    emit('update:modelValue',val)
    // console.log(val)
}
</script>

<template>
    <input
        :value="modelValue"
        :type="typeof type==='undefined'?'text':type"
        :class="['form-control',customClass]"
        @input="updateValue"
        :placeholder="typeof placeholder==='undefined'?'':placeholder"
    />
</template>
