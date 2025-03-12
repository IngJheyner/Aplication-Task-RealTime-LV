<script lang="ts" setup>

import { GetMemberType, MemberType } from '@/services/admin/member/listMemeber';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref } from 'vue';
import { myDebounce } from '@/helper/utils';

const query = ref('');

defineProps<{
    members: GetMemberType;
    loading: boolean;
}>()

const emit = defineEmits<{
    (e: 'edit', member: MemberType): void;
    (e: 'search', page:number, query: string): Promise<void>;
}>()


const search = myDebounce( async function() {
    emit('search', 1, query.value);
}, 500);

</script>

<template>
    <DataTable
    :value="members?.data?.data"
    tableStyle="min-width: 50rem"
    tableClass="table table-bordered table-hover table-striped"
    paginator
    :rows="10">
        <template #header>
            <div class="flex justify-between">
                <Input v-model="query" @keydown="search" type="text" :placeholder="'Buscar...'"/>
                <span style="color: blue;" v-show="loading===true ? true : false"><strong>Buscando...</strong></span>
            </div>
        </template>
        <Column field="id" header="ID"></Column>
        <Column field="name" header="Nombre"></Column>
        <Column field="email" header="Correo Electrónico"></Column>
        <Column :exportable="false" style="min-width: 12rem">
            <template #body="slotProps">
                <button class="btn btn-outline-primary" @click="emit('edit', slotProps.data)">Editar</button>
            </template>
        </Column>
    </DataTable>
</template>
