<template>
    <td>{{item.id}}</td>
    <td>
        <span :class="[item.completed ? 'completed' : '', 'itemText']">
            {{item.name}}
        </span>
    </td>
    <td>
        <span v-if="item.completed === 1">Done</span>
        <span v-else>Not Done</span>
    </td>
    <td>{{item.created}}</td>
    <td v-if="item.deleted != null">{{item.deleted}}</td>
    <td v-else>-</td>
    <td>
        <button @click="openEditModal(item)" v-show="item.deleted == null" class="plus-square" ref="inputRef">
            <font-awesome-icon icon="pen-to-square" />
        </button>
        <button @click="openDeleteModal" class="trashcan" v-if="item.deleted == null">
            <font-awesome-icon icon="trash" />
        </button>
        <button @click="handleRestore" class="btn-warning" v-show="item.deleted !=null">
            Restore
        </button>
    
        <!-- Modal Component -->
        <EditModal :showEditModal="showEditModal" :item="currentItem" @close="closeEditModal" @submit="updateItem"/>
        <DeleteModal :visible="isModalVisible" @confirm="handleDelete" @cancel="closeDeleteModal"/>
    </td>
</template>

<script>
import DeleteModal from './DeleteModal.vue';
import EditModal from './EditModal.vue';
export default {
    props: ["item"],
    components: {
        DeleteModal,
        EditModal
    },
    data() {
        return {
            isModalVisible: false,
            showEditModal: false,
            currentItem: null
        };
    },
    methods: {
        openEditModal(item) {
            this.currentItem = item ? { ...item } : { name: '', status: 'incomplete' };
            this.showEditModal = true;
        },
        closeEditModal() {
            this.showEditModal = false;
        },
        updateItem(updatedItem) {
        if (updatedItem.id) {
            // Update existing item
            axios.put(`api/tasks/${updatedItem.id}`, updatedItem)
            .then(() => {
                this.$emit('itemChanged');
            })
            .catch(error => console.error('Update failed:', error));
        } else {
            console.warn('No item to update or item has no ID.');
        }
        },
        openDeleteModal() {
            this.isModalVisible = true;
        },
        closeDeleteModal() {
            this.isModalVisible = false;
        },
        handleDelete() {
            this.isModalVisible = false;
            axios
                .delete("api/tasks/" + this.item.id)
                .then((response) => {
                    if (response.status == 200) {
                        this.$emit("itemChanged");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        handleRestore() {
            axios
                .get("api/tasks/restore/" + this.item.id)
                .then((response) => {
                    if (response.status == 200) {
                        this.$emit("itemChanged");
                        toastr.success(response.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },

    mounted() {
        this.item.completed ? this.$refs.inputRef.checked = true : '';
    },

};
</script>

<style scoped>
.completed {
    text-decoration: line-through;
    color: #999;
}

.itemText {
    width: 100%;
    margin-left: 20px;
}

.item {
    display: flex;
    justify-content: center;
    align-items: center;
}

.trashcan {
    background: #e6e6e6;
    border: none;
    color: #ff0000;
    outline: none;
    cursor: pointer;
}
.plus-square {
    background: #e6e6e6;
    border: none;
    color: #1ae538;
    outline: none;
    cursor: pointer;
}
</style>