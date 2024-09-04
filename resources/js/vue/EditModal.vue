<!-- ModalComponent.vue -->
<template>
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content">
        <button class="close-button" @click="closeEditModal">×</button>
        <h2>Update Task</h2>
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" v-model="form.name" id="name"  @input="clearErrorMessage"/>
          </div>
          <div v-if="errorMessage" class="error-message">
            {{ errorMessage }}
         </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <select v-model="form.completed" id="completed">
              <option value="0">Incomplete</option>
              <option value="1">Complete</option>
            </select>
          </div>
          <button type="submit" class="submit-button">Save</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      showEditModal: Boolean,
      item: Object
    },
    data() {
      return {
        form: { ...this.item },
        errorMessage: ''
      };
    },
    methods: {
        closeEditModal() {
            this.$emit('close'); // Emit an event to close the modal
        },
        submitForm() {
            this.errors = {};

            axios.put(`api/tasks/${this.form.id}`, this.form)
            .then(() => {
            this.$emit('submit', this.form);
            this.closeEditModal(); // Close the modal after submission
            })
            .catch((error) => {
            if (error.response && error.response.data) {
                // Handle validation errors from the API response
                this.errorMessage = error.response.data.message || 'An unexpected error occurred.';
            } else {
                this.errorMessage = 'An unexpected error occurred.';
            }
            });
        },
        clearErrorMessage() {
            if (this.item.name.trim() !== "") {
                this.errorMessage = ''; // Clear error message when input is not empty
            }
        }
    },
    watch: {
      item: {
        handler(newItem) {
          this.form = { ...newItem }; // Update form when item prop changes
        },
        deep: true
      }
    }
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3); /* Slightly darker overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure modal is on top of other content */
  }
  
  .modal-content {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px; /* Max width for better readability */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
    position: relative;
  }
  
  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #333;
  }
  
  h2 {
    margin-top: 0;
    font-size: 1.5em;
    color: #333;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #666;
  }
  
  input[type="text"],
  select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
  }
  
  .submit-button {
    background: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  
  .submit-button:hover {
    background: #0056b3;
  }

.error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
    text-align: center;
}
  </style>
  