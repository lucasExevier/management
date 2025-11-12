<script>
export default {
  name: 'About',
  data() {
    return {
      title: 'About Us',
      description: 'This is the about page',
    };
  },
};
</script>

<template>
  <div class="about">
    <h2>{{ title }}</h2>
    <p>{{ description }}</p>
    <p>Here you can add information about your project or organization.</p>
  </div>
</template>

<style scoped>
.about {
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
