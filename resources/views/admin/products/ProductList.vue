<script setup>
import { onMounted, ref, toRaw, watch } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import ProductListItem from "./ProductListItem.vue";
import { useRouter } from 'vue-router'

const router = useRouter();

const products = ref({
  data: [],
});

const categories = ref([]);

const list = ref({
  search: "",
  category: "",
});

const getProducts = (page = 1) => {
  axios.get(`/api/products?page=${page}`, {
    params: {
        search: list.value.search,
        category: list.value.category,
    }
  }).then((response) => {
    products.value = response.data;
  });
};

const getCategories = () => {
  axios.get("/api/categories").then((response) => {
    categories.value = response.data.data;
  });
};

const edtProduct = (product) => {
    router.push({ name: "admin.products.edit", params: { id: product.id } });
};

onMounted(() => {
  getProducts();
  getCategories();
});

watch(
  () => list,
  (list) => {
    getProducts();
  },
  { deep: true },
)
</script>
<template>
  <div class="content mt-5">
    <div class="container-fluid">
      <div class="d-flex justify-content-between">
        <div class="d-flex">
                      <select v-model="list.category" class="form-control mb-2 mr-2">
            <option value="">Select a Category</option>
            <option
                v-for="(category) in categories"
                :key="category.id"
                :value="category.id">{{ category.name }}</option>
          </select>
                    <!-- <div v-if="selectedUsers.length > 0">
                        <button @click="bulkDelete" type="button" class="ml-2 mb-2 btn btn-danger">
                            <i class="fa fa-trash mr-1"></i>
                            Delete Selected
                        </button>
                        <span class="ml-2">Selected {{ selectedUsers.length }} users</span>
                    </div> -->
        </div>
        <div>

          <input type="text" v-model="list.search" class="form-control" placeholder="Search..." />
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>
                  <!-- <input type="checkbox" v-model="selectAll" @change="selectAllUsers" /> -->
                </th>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Date and Time</th>
              </tr>
            </thead>
            <tbody v-if="products.data.length > 0">
              <ProductListItem
                v-for="(product, index) in products.data"
                :key="product.id"
                :product="product"
                :index="index"
                @edit-product="edtProduct"
              />
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="6" class="text-center">No results found...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Bootstrap4Pagination
        :data="products"
        @pagination-change-page="getProducts"
      />
    </div>
  </div>
</template>
