
import { useLocalStorage } from '@vueuse/core';
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        admin: useLocalStorage('admin', null),
        token: useLocalStorage('token', null),
    }),
    getters: {
        getAdmin: (state) => state.admin,
        getToken: (state) => state.token,
    },
    actions: {
        isAuthenticated() {
            return this.admin !== null;
        },
        async login({ identifier, password }) {
            try {
                const {
                    data: { admin, token }
                } = await axios.post('/api/admins/login', {
                    identifier,
                    password
                });
                this.admin = JSON.stringify(admin);
                this.token = token;
            } catch ({ response }) {
                throw new Error(response.data.message);
            }
        },
        // todo: logout endpoint
        logout() {
            this.admin = null;
            this.token = null;
        }
    }
});
