<template>
<h1>Vue component to go here</h1>
</template>

<script>
import {ref, onMounted} from 'vue'

export default {
    setup() {
        onMounted(() => {
            console.log('Loaded');
        });
    },
}
</script>
