<template>
    <AuthContainer>
        <form @submit.prevent="RequestResetPassword">
            <h1>Wachtwoord vergeten</h1>
            <p>Vul hieronder je e-mailadres in. Je ontvangt dan instructies om je wachtwoord opnieuw in te stellen.</p>

            <div class="mb-2">
                <label for="email">Email</label>
                <input v-model="email" type="email" class="form-control" name="email" placeholder="e-mailadres" />
                <BaseFormError name="email" />
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button class="m-1 btn btn-primary" @click="sendEmailResetPassword">Verzenden</button>
                <router-link class="" :to="{name: 'Login'}">Terug</router-link>
            </div>
        </form>
    </AuthContainer>
</template>

<script setup>
import {goToLoginPage} from '..';
import {postRequest} from 'services/http';
import {ref} from 'vue';
import {successToast} from 'services/toast';
import AuthContainer from '../components/AuthContainer.vue';
import BaseFormError from 'components/FormError.vue';

const email = ref('');

const sendEmailResetPassword = async () => {
    await postRequest('send-email-reset-password', {email: email.value});
    successToast('E-mail gestuurd met link om password te resetten');
    goToLoginPage();
};
</script>
