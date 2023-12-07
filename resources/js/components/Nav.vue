<template>
    <div class="container-fluid bg-primary">
        <nav class="navbar navbar-expand-md">
            <div class="container-fluid m-0">
                <a class="navbar-brand" href="/">TimeTrack</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon" />
                </button>
                <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link
                                v-if="getLoggedInUser?.id == 1"
                                class="btn bg-white ms-1"
                                :to="{name: 'users.overview'}"
                            >
                                Gebruikers
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="btn bg-white ms-1" :to="{name: 'dashboard.overview'}">
                                Dashboard
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="btn bg-white ms-1" :to="{name: 'companies.overview'}">Werk</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="btn bg-white ms-1" :to="{name: 'hours.overview'}">Uren</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item">
                            <a class="btn bg-white" @click="submitLogout">{{ getLoggedInUser?.firstName }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script setup lang="ts">
import {getLoggedInUser, goToLoginPage, logout} from 'domains/auth';

const submitLogout = async () => {
    try {
        await logout();
    } finally {
        goToLoginPage();
    }
};
</script>
<style>
.router-link-exact-active {
    background-color: rgba(255, 255, 255, 0.15);
}
</style>
