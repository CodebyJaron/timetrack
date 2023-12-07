<template>
    <AuthContainer>
        <form @submit.prevent="ResetPassword">
            <h1>Nieuw wachtwoord</h1>
            <input type="hidden" name="e-mail" :value="email" />
            <div class="mb-2">
                <label for="password">Wachtwoord</label>
                <input
                    v-model="credentials.password"
                    placeholder="Nieuw wachtwoord"
                    type="password"
                    class="form-control"
                    autocomplete="new-password"
                />
                <BaseFormError name="password" />
            </div>

            <div class="mb-2">
                <label for="email">Herhaal Wachtwoord</label>
                <input
                    v-model="credentials.password_confirmation"
                    placeholder="Herhaal nieuw wachtwoord"
                    class="form-control"
                    type="password"
                    autocomplete="new-password"
                />
                <BaseFormError name="token" />
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary m-1" @click="resetPassword">Reset password</button>
                <router-link class="" :to="{name: 'Login'}">Inloggen</router-link>
            </div>
        </form>
    </AuthContainer>
</template>

<script setup>
import {goToLoginPage} from '..';
import {postRequest} from 'services/http';
import {reactive} from 'vue';
import {successToast} from 'services/toast';
import {useRoute} from 'vue-router';
import AuthContainer from '../components/AuthContainer.vue';
import BaseFormError from 'components/FormError.vue';

const {email, token} = useRoute().params;

const credentials = reactive({token, email});
const resetPassword = async () => {
    await postRequest('reset-password', credentials);
    successToast('Je wachtwoord is succesvol aangepast. Login om verder te gaan.');
    goToLoginPage();
};
</script>
