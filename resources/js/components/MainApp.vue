<template>
    <div class="min-h-screen bg-[#edf0f3] text-slate-900">
        <Header />
        <main>
            <router-view />
        </main>
        <Footer />
        <LiveChatBot />
    </div>
</template>

<script setup>
import Header from "./layout/Header.vue";
import Footer from "./layout/Footer.vue";
import LiveChatBot from "./common/LiveChatBot.vue";
</script>
