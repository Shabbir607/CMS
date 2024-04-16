
import { defineStore } from 'pinia';
import axios from 'axios';

export const useProfileStore = defineStore('profile', {
    state: () => ({
        username: '',
        email: '',
        phone: '',
        image: '',
    }),
    actions: {
        async fetchData() {
            try {
                const response = await axios.get('api/admin_profile/get');

                this.username = response.data.profile.name
                this.email = response.data.profile.email
                this.image = response.data.profile.image
                this.phone = response.data.profile.phone
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
    },
});
