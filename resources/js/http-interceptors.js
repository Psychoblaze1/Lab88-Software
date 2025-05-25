import axios from 'axios';
import router from './router';

export default function setUpInterceptors() {
    axios.interceptors.response.use(function (response) {
        // Handle successful responses
        return response;
    }, function (error) {
        // Check for an unauthorized response
        if (error.response.status === 401) {
            // Redirect to the login page
            router.push({ name: 'login' });
        }
        return Promise.reject(error);
    });
}