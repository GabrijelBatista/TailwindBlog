<template class="z-50">
<div class="min-h-screen min-w-full items-center justify-center overflow-x-hidden">
    <transition name="fade"  mode="out-in">
    <div :key="expand" v-show="expand" class="fixed z-50 top-0 left-0 right-0 bottom-0 w-full h-screen overflow-hidden bg-gray-700 bg-opacity-90 flex flex-col items-center justify-center">
        <button @click="expanded()"><svg xmlns="http://www.w3.org/2000/svg" class="right-0 top-0 mt-2 mr-2 absolute h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="white">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg></button>
        <div class="flex container mx-auto items-center justify-center">
            <div>
                <button v-show="images[1]" @click="prev()"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-10 w-10" viewBox="0 0 20 20" fill="white">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg></button>
                <transition name="slide-fade"  mode="out-in">
                    <img class="object-scale-down inline-block m-auto h-screen w-3/4" :key="images[active]" :src="images[active]">
                </transition>
                <button v-show="images[1]" @click="next()"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-10 w-10" viewBox="0 0 20 20" fill="white">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg></button>
            </div>
        </div>
    </div>
    </transition>
    <div class="bg-black bg-opacity-70 sticky h-2/3">
    <transition name="slide-fade"  mode="out-in">
        <div id="slider-1" :key="images[active]" class=" bg-cover bg-center mx-auto min-w-full" :style="{backgroundImage: `url(${images[active]})`}">
            <div class="text-white pt-28 pb-10 px-10 object-fill">
                <div class="flex justify-between w-full mx-auto bottom-0 mt-20 pb-2">
                    <button v-show="images[1]" v-on:click.stop @click="prev()"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg></button>
                    <button v-show="images[1]" v-on:click.stop @click="next()"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg></button>
                </div>
                <div class="absolute float-left bottom-5">
                    <p class="text-xl leading-none">Some info eg. Author/Date</p>
                </div>
                <button class="absolute float-right bottom-5 right-5" @click="expanded()"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg></button>
            </div>
        </div>
    </transition>
    </div>
    <div class="bg-black bg-opacity-70 min-w-full min-h-screen text-white font-serif">
        <h1 class="text-center text-5xl py-16">Naslov naslov</h1>
        <p class="text-center py-5 mx-auto w-2/3">Text TextText Text TextTexText TextText Text TextText Text TextText Text TextText Text TextText Text TextText Text TextTextt Text TextText</p>
        <p class="text-center py-5 mx-auto w-2/3">Text TextText Text TextTexText TextText Text TextText Text TextText Text TextText Text TextText Text TextText Text TextTextt Text TextText</p>
        <p class="text-center py-5 mx-auto w-2/3">Text TextText Text TextTexText TextText Text TextText Text TextText Text TextText Text TextText Text TextText Text TextTextt Text TextText</p>
    </div>
</div>
</template>
<script>
    export default{
        data: function() {
            return{
                expand: false,
                active: 0,
                images: {
                    0 : 'https://wallpapercave.com/wp/wp5405231.jpg',
                    1 : 'https://wallpapercave.com/wp/wp4964086.png',
                }
            }
        },
        computed:{
            current_image(url){
                if(url){
                    return url;
                }
                else{
                    return this.images[0];
                }
            }
        },
        methods: {
            prev(){
                if(this.active>0){
                   this.active--;
                }
                return this.active;
            },
            next(){
                if(this.images[this.active+1]){
                    this.active++;
                }
                return this.active;
            },
            expanded() {
                this.expand=!this.expand;
                if(this.expand) {
                    document.documentElement.style.overflowY = "hidden";
                }
                else{
                    document.documentElement.style.overflowY = "visible";
                }
            }
        },
    }
</script>
<style scoped>
#slider-1{
    height:60vh;
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
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-in;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

</style>
