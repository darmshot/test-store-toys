import axios, {AxiosInstance} from 'axios';

const axiosInstance: AxiosInstance = axios.create();

// const xsrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
// var xsrfToken = decodeURIComponent(readCookie('XSRF-TOKEN'));
// axiosInstance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const webp = document.querySelector('meta[name="webp"]');

const cartSession = document.querySelector('meta[name="cart-session"]')

if (webp) {
    axiosInstance.defaults.headers.common['WEBP'] = true;
}

if (cartSession) {
    axiosInstance.defaults.headers.common['CART-SESSION'] = cartSession.getAttribute('content')
}

export default axiosInstance;
