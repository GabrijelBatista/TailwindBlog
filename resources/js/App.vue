<template>
  <NavBar class="sticky z-40 inset-x-0 shadow-xl lg:w-3/4 lg:mx-auto lg:top-10 top-0 rounded-lg"/>
    <router-view v-slot="{ Component }" class="-mt-16 bg-hero-lg bg-cover bg-fixed">
      <transition name="slide-fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
</template>

<script>
import NavBar from './components/NavBar.vue'
export default{
  components: {
    NavBar
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
.slide-fade-enter-active {
    transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
