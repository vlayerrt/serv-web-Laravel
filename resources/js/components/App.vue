<template>
    <div v-if="article" class="alert alert-primary alert-dismissible" role="alert">
        Добавлена новая статья <strong><a :href="article.url">{{ article.title }}</a></strong>
        <button type="button" class="btn-close" @click="article = null" aria-label="Закрыть"></button>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const article = ref(null);
let channel;

onMounted(() => {
    if (window.Echo) {
        channel = window.Echo.channel('test').listen('NewArticleEvent', (event) => {
            article.value = event.article;
            window.dispatchEvent(new Event('article-created'));
        });
    }
});

onBeforeUnmount(() => {
    if (channel && window.Echo) window.Echo.leave('test');
});
</script>
