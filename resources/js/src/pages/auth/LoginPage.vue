<script lang="ts" setup>
import { loginInput, userLoginUser } from '@/services/auth/login';
import { useVuelidate } from '@vuelidate/core';
import { required, email, helpers, minLength } from '@vuelidate/validators';
import Error from '@/components/Error.vue';
import Input from '@/components/Input.vue';
import Button from '@/components/Button.vue';

const rules = {
    email: {
        required: helpers.withMessage('El correo electrónico es requerido.', required),
        email: helpers.withMessage('El correo electrónico no es válido.', email),
    }, // Matches state.firstName
    password: {
        required: helpers.withMessage('La contraseña es requerida.', required),
        minLength: helpers.withMessage('La contraseña debe tener al menos 6 caracteres.', minLength(6)),
    }, // Matches state.lastName
};

const v$ = useVuelidate(rules, loginInput);
const { loading, login } = userLoginUser();

async function submitLogin() {

    const result = await v$.value.$validate();

    if (!result) return;

    await login();
    v$.value.$reset()

}
</script>

<template>
    <div class="register min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row justify-content-center align-items-center w-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>
                        <!-- {{ loginInput }} -->
                        <form @submit.prevent="submitLogin">
                            <div class="mb-3">
                                <Error
                                    label="E-mail"
                                    :errors="v$.email.$errors"
                                >
                                    <Input v-model="loginInput.email" />
                                </Error>
                            </div>
                            <div class="mb-3">
                                <Error
                                    label="Contraseña"
                                    :errors="v$.password.$errors"
                                >
                                    <Input
                                        type="password"
                                        v-model="loginInput.password"
                                    />
                                </Error>
                            </div>
                            <br />
                            <div class="mb-3">
                                <RouterLink to="/register">Registrarse</RouterLink>
                            </div>
                            <div class="d-grid">

                               <Button label="Entrar" :loading="loading"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
