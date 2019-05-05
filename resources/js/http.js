const axios = require('axios');

const axiosInstance = axios.create({
    baseURL: window.API_DOMAIN,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
});

module.exports = axiosInstance;
