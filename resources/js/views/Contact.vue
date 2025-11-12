<script>
export default {
  name: 'Contact',
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: '',
      },
    };
  },
  methods: {
    submitForm() {
      alert(`Thank you ${this.form.name}, your message has been sent!`);
      this.form = { name: '', email: '', message: '' };
    },
  },
};
</script>

<template>
  <div class="contact">
    <h2>Contact Us</h2>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="name">Name:</label>
        <input v-model="form.name" type="text" id="name" required />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input v-model="form.email" type="email" id="email" required />
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea v-model="form.message" id="message" required></textarea>
      </div>
      <button type="submit">Send Message</button>
    </form>
  </div>
</template>

<style scoped>
.contact {
  max-width: 600px;
  margin: 0 auto;
}

h2 {
  color: #333;
}

.form-group {
  margin-bottom: 1.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  color: #333;
  font-weight: bold;
}

input,
textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-family: inherit;
}

textarea {
  resize: vertical;
  min-height: 150px;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #45a049;
}
</style>
