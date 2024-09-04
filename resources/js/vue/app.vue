<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Php-Simple To Do List App</h2>
            <button @click="toggleFilter" :class="{'show-all-default': !showAll,'show-all-primary': showAll}">
            {{ showAll ? 'New Added Tasks' : 'Show All Tasks' }}
        </button>
        <addItemForm @reloadlist="getList()" />
        </div>
        <listView :items="items" @reloadlist="getList()" />
    </div>
</template>

<script>
import addItemForm from './addItemForm.vue';
import listView from './listView.vue';
import axios from "axios";
export default {
    data() {
        return {
            items: [],
            showAll: false,   // Flag to show all tasks or incomplete tasks
            loading: false,   // Loading state
            error: null       // Error state
        }
    },
    components: {
        addItemForm,
        listView
    },
    methods: {
        getList() {
            const params = this.showAll ? { deleted: 1} : { completed: 0};
            axios.get("api/tasks", {
                    params
                }).then((response)=> {
                this.items = response.data.results
            }).catch((error) => {
                console.log(error);
            })
        },
        toggleFilter() {
            this.showAll = !this.showAll;
            this.getList();
        }
    },
    mounted() {
        this.getList();
    }
}
</script>

<style scoped>
.todoListContainer {
    width: 700px;
    height: 1000px;
    margin: auto;
}

.heading {
    background: #e6e6e6;
    padding: 10px
}

#title {
    text-align: center;
}
.btn-default {
  background-color: #f0f0f0;
  color: #333;
  border: 1px solid #ccc;
  padding: 10px 20px;
  cursor: pointer;
}
.btn-active {
  background-color: #007bff;
  color: white;
  border: 1px solid #ccc;
  padding: 10px 20px;
  cursor: pointer;
}
.show-all-default {
  background-color: #f0f0f0;
  color: #333;
  border: 1px solid #ccc;
  padding: 10px 20px;
  cursor: pointer;
  float: right;
}
.show-all-primary {
  background-color: #3178d4;
  color: #333;
  border: 1px solid #ccc;
  padding: 10px 20px;
  cursor: pointer;
  float: right;
}
</style>