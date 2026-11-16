<template>
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Уведомления <span class="badge bg-primary">{{ notifications.length }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><h6 class="dropdown-header">Новые статьи</h6></li>
        <li v-for="notification in notifications" :key="notification.id">
            <a class="dropdown-item" :href="notification.url">{{ notification.title }}</a>
        </li>
        <li v-if="notifications.length === 0">
            <span class="dropdown-item-text text-secondary">Нет новых уведомлений</span>
        </li>
    </ul>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import axios from 'axios';

const notifications = ref([]);

async function refreshNotifications() {
    try {
        const response = await axios.get('/notifications/unread');
        notifications.value = response.data;
    } catch (error) {
        console.error('Не удалось обновить список уведомлений.', error);
    }
}

onMounted(() => {
    refreshNotifications();
    window.addEventListener('article-created', refreshNotifications);
});

onBeforeUnmount(() => {
    window.removeEventListener('article-created', refreshNotifications);
});
</script>
