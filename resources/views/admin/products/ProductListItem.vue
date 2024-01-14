<script setup>
const props = defineProps({
    product: Object,
    index: Number,
    selectAll: Boolean,
});

const emit = defineEmits(['editProduct', 'toggleSelection']);

const toggleSelection = () => {
    emit('toggleSelection', props.product);
}
</script>
<template>
    <tr>
        <td>
            <input type="checkbox" :checked="selectAll" @change="toggleSelection" />
        </td>
        <td>{{ index + 1 }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.description }}</td>
        <td>{{ product.category.name }}</td>
        <td>{{ product.date_and_time }}</td>
        <td>
            <a href="#" @click.prevent="$emit('editProduct', product)"><i class="fa fa-edit"></i></a>
        </td>
    </tr>
</template>
