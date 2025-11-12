<script>
export default {
  name: 'App',
};
</script>

<template>
  <div id="app" class="app-container">
    <nav class="navbar">
      <div class="navbar-brand">
        <h1>My Laravel Vue App</h1>
      </div>
      <ul class="nav-links">
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/about">About</router-link></li>
        <li><router-link to="/contact">Contact</router-link></li>
      </ul>
    </nav>
    
    <main class="main-content">
      <router-view></router-view>
    </main>
  </div>
</template>

<style scoped>
.app-container {
  font-family: Arial, sans-serif;
}

.navbar {
  background-color: #333;
  color: white;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar-brand h1 {
  margin: 0;
  font-size: 1.5rem;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 2rem;
  margin: 0;
  padding: 0;
}

.nav-links a {
  color: white;
  text-decoration: none;
  transition: color 0.3s;
}

.nav-links a:hover {
  color: #4CAF50;
}

.main-content {
  padding: 2rem;
  min-height: calc(100vh - 80px);
}
</style>

