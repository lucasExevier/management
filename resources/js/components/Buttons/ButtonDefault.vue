<template>
  <button class="btn btn-default">
    <slot>Click Me</slot>
  </button>
</template>

<script>
export default {
  name: 'ButtonDefault',
};
</script>

<style scoped>
.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.btn-default {
  background-color: #000;
  color: white;
}

.btn-default:hover {
  background-color: #333;
  transform: scale(1.05);
}

.btn-default:active {
  transform: scale(0.95);
}
</style>