import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import NotificationMenu from './components/NotificationMenu.vue';

const notificationMenu = document.getElementById('notifications-menu');
if (notificationMenu) {
    createApp(NotificationMenu).mount(notificationMenu);
}

createApp(App).mount('#app');
