<script lang="ts" setup>

import { useVuelidate } from '@vuelidate/core';
import { required, email, helpers, minLength } from '@vuelidate/validators';
import { useCreateOrUpdateProject } from '@/services/admin/projects/createProject';
import { projectStore } from '@/store/projectStore';

const rules = {
    name: {
        required: helpers.withMessage('El nombre es requerido.', required),
    },
    start_date: {
        required: helpers.withMessage('La fecha de inicio es requerida.', required),
    },
    end_date: {
        required: helpers.withMessage('La fecha de fin es requerida.', required),
    }
};

const v$ = useVuelidate(rules, projectStore.projectInput);

const { loading, createOrUpdate } = useCreateOrUpdateProject();

async function submitCreateOrUpdate() {

    const result = await v$.value.$validate();

    if (!result) return;

    await createOrUpdate();
    v$.value.$reset()

}

</script>

<template>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mb-4" v-text="projectStore.edit ? 'Editar' : 'Crear'"></h3>
            <form @submit.prevent="submitCreateOrUpdate">
                <div class="mb-3">
                    <Error
                        label="Nombre"
                        :errors="v$.name.$errors"
                    >
                        <Input v-model="projectStore.projectInput.name"/>
                    </Error>
                </div>
                <div class="mb-3">
                    <Error
                        label="Fecha inicio"
                        :errors="v$.start_date.$errors"
                    >
                        <Input v-model="projectStore.projectInput.start_date" type="date" />
                    </Error>
                </div>
                <div class="mb-3">
                    <Error
                        label="Fecha fin"
                        :errors="v$.end_date.$errors"
                    >
                        <Input v-model="projectStore.projectInput.end_date" type="date" />
                    </Error>
                </div>
                <div class="d-grid">
                    <Button
                    :label="projectStore.edit ? 'Actualizar proyecto' : 'Crear proyecto'"
                    :loading="loading"/>
                </div>
            </form>
        </div>
    </div>
</template>
