import axiosCustom from 'axios'

const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content

axiosCustom.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken

export default axiosCustom