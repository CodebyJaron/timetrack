<template>
    <AuthContainer>
        <h1>Manos</h1>
        <form @submit.prevent="submit">
            <div class="mb-2">
                <label for="email">Voornaam:</label>
                <input v-model="userToRegister.firstName" type="text" class="form-control" name="firstName" disabled />
            </div>
            <div class="mb-2">
                <label for="email">Achternaam:</label>
                <input v-model="userToRegister.lastName" type="text" class="form-control" name="lastName" disabled />
            </div>
            <div class="mb-2">
                <label for="email">Email:</label>
                <input v-model="userToRegister.email" type="text" class="form-control" name="email" disabled />
            </div>
            <div class="mb-2">
                <label for="email">Wachtwoord:</label>
                <input v-model="newCredentials.password" type="password" class="form-control" name="password" />
            </div>
            <div class="mb-2">
                <label for="password">Herhaal wachtwoord:</label>
                <input
                    v-model="newCredentials.repeatedPassword"
                    type="password"
                    class="form-control"
                    name="repeatedPassword"
                />
            </div>
            <div class="pt-3">
                <button>Registreren</button>
            </div>
        </form>
    </AuthContainer>
</template>

<script setup lang="ts">
import {DASHBOARD_DOMAIN_NAME} from 'domains/dashboard';
import {User} from 'domains/users/types';
import {getCurrentRouteToken, goToOverviewPage} from 'services/router';
import {getRequest, postRequest} from 'services/http';
import {login} from '..';
import {ref} from 'vue';
import AuthContainer from '../components/AuthContainer.vue';

const newCredentials = ref({password: '', repeatedPassword: ''});

const userToRegister = ref<User>({
    id: 0,
    firstName: '',
    lastName: '',
    email: '',
    inviteToken: '',
    isAdmin: false,
    companies: [],
});

const getUserToRegister = async (token: string) => {
    const {data} = await getRequest(`get-user-to-register/${token}`);
    if (!data) return;
    userToRegister.value = data;
};

const submit = async () => {
    await postRequest(`register/${userToRegister.value.inviteToken}`, newCredentials.value);
    await login({email: userToRegister.value.email, password: newCredentials.value.password});
    goToOverviewPage(DASHBOARD_DOMAIN_NAME);
};

getUserToRegister(getCurrentRouteToken());
</script>

<style></style>
