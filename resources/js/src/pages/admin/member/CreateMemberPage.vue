<script lang="ts" setup>

import { useVuelidate } from '@vuelidate/core';
import { required, email, helpers, minLength } from '@vuelidate/validators';
import { useCreateOrUpdateMember } from '@/services/admin/member/createMember';
import { memberStore } from '@/store/memberStore';

const rules = {
    name: {
        required: helpers.withMessage('El nombre es requerido.', required),
    },
    email: {
        required: helpers.withMessage('El correo electrónico es requerido.', required),
        email: helpers.withMessage('El correo electrónico no es válido.', email),
    }
};

const v$ = useVuelidate(rules, memberStore.memberInput);

const { loading, createOrUpdate } = useCreateOrUpdateMember();

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
            <h3 class="mb-4" v-text="memberStore.edit ? 'Editar' : 'Crear'"></h3>
            <form @submit.prevent="submitCreateOrUpdate">
                <div class="mb-3">
                    <Error
                        label="Nombre"
                        :errors="v$.name.$errors"
                    >
                        <Input v-model="memberStore.memberInput.name" type="text" />
                    </Error>
                </div>
                <div class="mb-3">
                    <Error
                        label="E-mail"
                        :errors="v$.email.$errors"
                    >
                        <Input v-model="memberStore.memberInput.email" type="email" />
                    </Error>
                </div>
                <div class="d-grid">
                    <Button
                    :label="memberStore.edit ? 'Actualizar miembro' : 'Crear miembro'"
                    :loading="loading"/>
                </div>
            </form>
        </div>
    </div>
</template>
