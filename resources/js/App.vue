<template>
    <AppContainer>
        <Nav v-if="isLoggedIn" />
        <router-view />
    </AppContainer>
</template>

<script setup>
import {isLoggedIn} from 'domains/auth';
import AppContainer from 'components/AppContainer.vue';
import Nav from './components/Nav.vue';
</script>
