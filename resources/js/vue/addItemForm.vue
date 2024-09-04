<template>
    <div class="addItem">
        <input type="text" v-model="item.name"  placeholder="Enter task name" @input="clearErrorMessage">
        <button type="button" @click="addItem()" :class="[item.name ? 'active' : 'inactive', 'plus']">Add Task</button>
    </div>
    <div v-if="errorMessage" class="error-message">
        {{ errorMessage }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            item: {
                name: ''
            },
            errorMessage: ''
        }
    },
    methods: {
        addItem() {
            if (this.item.name == "") {
                return;
            }
            axios
            .post("api/tasks", {
                    name: this.item.name,
                })
                .then((response) => {
                    if (response.status == 201) {
                        this.item.name = "";
                        this.$emit('reloadlist');
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.data) {
                        this.errorMessage = error.response.data.message || 'An unexpected error occurred.';
                    } else {
                        this.errorMessage = 'An unexpected error occurred.';
                    }
                });
        },
        clearErrorMessage() {
            if (this.item.name.trim() !== "") {
                this.errorMessage = '';
            }
        }
    }
}
</script>

<style scoped>
.addItem {
    display: flex;
    justify-content: center;
    align-items: center;
}

input {
    background: #f7f7f7;
    border: 0;
    outline: none;
    padding: 5px;
    margin-right: 10px;
}

.plus {
    font-size: 20px;
    cursor: pointer;
}

.active {
    display: inline-block;
    font-weight: 400;
    color: #d9dcdf;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out;
    background-color: rgb(68, 170, 68);
    border-color: 0.15s ease-in-out;
    box-shadow: 0.15s ease-in-out;
}

.inactive {
    color: #999
}

.error-message {
    color: red;
    margin-top: 10px;
    font-size: 14px;
    text-align: center;
}
</style>