<template>
  <router-view></router-view>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuth } from './auth';

const { fetchMe } = useAuth();

onMounted(() => {
    fetchMe();
});
</script>

