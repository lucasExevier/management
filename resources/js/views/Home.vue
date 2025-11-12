<script>
import ButtonDefault from '../components/Buttons/ButtonDefault.vue';

export default {
  name: 'Home',
  components: {
    ButtonDefault,
  },
  data() {
    return {
      message: 'Welcome to the Home Page',
    };
  },
};
</script>

<template>
  <div class="home">
    <h2>{{ message }}</h2>
    <p>This is the home page of your Vue Laravel application.</p>
    <ButtonDefault />
  </div>
</template>

<style scoped>
.home {
  max-width: 600px;
  margin: 0 auto;
}

h2 {
  color: #333;
}

p {
  color: #666;
  line-height: 1.6;
}
</style>
