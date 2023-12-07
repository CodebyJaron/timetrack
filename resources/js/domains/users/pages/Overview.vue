<template>
    <PageContainer>
        <Card>
            <div class="d-flex justify-content-between">
                <h2>Gebruiker overzicht</h2>
                <div class="d-grid gap-2 d-md-block m-1">
                    <button class="btn btn-primary" type="button" @click="createCreateModal">
                        <FontAwesomeIcon :icon="fasPlus" />
                    </button>
                </div>
            </div>
            <table class="table table-hover table-sm align-middle">
                <thead>
                    <tr>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.firstName }} {{ user.lastName }}</td>
                        <td>{{ user.email }}</td>
                        <td v-if="!user.inviteToken">Actief</td>
                        <td v-else>
                            Uitgenodigd
                            <button class="btn btn-primary btn-sm" @click="reinviteUser(user)">
                                <FontAwesomeIcon :icon="farPaperPlane" />
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="createEditModal(user)">
                                <FontAwesomeIcon :icon="fasEdit" />
                            </button>
                            <button
                                class="btn btn-primary btn-sm ms-1"
                                :class="getLoggedInUser?.id == user.id ? 'disabled' : ''"
                                @click="removeUser(user)"
                            >
                                <FontAwesomeIcon :icon="fasTrash" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Card>
    </PageContainer>
</template>

<script setup lang="ts">
import {New, Updatable} from 'services/store/types';
import {User} from '../types';
import {computed, defineAsyncComponent, ref} from 'vue';
import {confirmModal, formModal} from 'services/modal';
import {farPaperPlane, fasEdit, fasPlus, fasTrash} from 'constants/icons';
import {getLoggedInUser} from 'domains/auth';

import {sortBy} from 'helpers/sort';
import {successToast} from 'services/toast';
import {userStore} from '..';
import Card from 'components/Card.vue';
import FontAwesomeIcon from 'components/FontAwesomeIcon.vue';
import PageContainer from 'components/PageContainer.vue';

userStore.actions.getAll();

const newUser = ref<New<User>>({
    firstName: '',
    lastName: '',
    email: '',
    inviteToken: '',
    isAdmin: false,
    companies: [],
});

const users = computed(() => sortBy(userStore.getters.all.value, 'firstName'));

const createCreateModal = () => {
    formModal(
        newUser.value,
        defineAsyncComponent(() => import('../components/Form.vue')),
        async (user: New<User>) => {
            await userStore.actions.create(user);
            successToast('Gebruiker uitgenodigd');
        },
    );
};

const createEditModal = (user: User) => {
    formModal(
        user,
        defineAsyncComponent(() => import('../components/Form.vue')),
        async (editedUser: Updatable<User>) => {
            await userStore.actions.update(user.id, editedUser);
            successToast('Gebruiker aangepast');
        },
    );
};

const removeUser = async (user: User) => {
    const confirmed = await confirmModal(`Weet je zeker dat je "${user.firstName}" wilt verwijderen?`, 'Verwijderen');
    if (!confirmed) return;
    userStore.actions.delete(user.id);
    successToast('Gebruiker verwijderd');
};

const reinviteUser = async (user: User) => {
    const confirmed = await confirmModal(
        `Weet je zeker dat je "${user.firstName}" opnieuw wilt uitnodigen?`,
        'Accepteren',
    );
    if (!confirmed) return;

    userStore.actions.reinviteUser(user);
    successToast('Gebruiker opnieuw uitgenodigd');
};
</script>
