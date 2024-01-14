<script setup>
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref, watch } from "vue";
import { Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import FormWizard from "@components/Form/FormWizard.vue";
import FormStep from "@components/Form/FormStep.vue";

const route = useRoute();
const router = useRouter();

const product = ref({
    name: '',
    category_id: '',
    description: '',
    date_and_time: '',
    images: [],
});

const categories = ref([]);

const getProduct = () => {
  axios
    .get(`/api/products/${route.params.id}`)
    .then((response) => {
      product.value = response.data.data;
    });
};

const getCategories = () => {
  axios.get("/api/categories").then((response) => {
    categories.value = response.data.data;
  });
};

const validationSchema = [
  yup.object({
    name: yup.string().required().label("Product Name"),
    category_id: yup.string().required().label("Product Category"),
    description: yup.string().required().label("Product Description"),
  }),
  yup.object({
    images: yup.mixed().required(),
  }),
  yup.object({
    date_and_time: yup.date().required(),
  }),
];

function onSubmit(formData) {
  const headers = { "Content-Type": "multipart/form-data" };
  const params = { _method: "put" };

  axios.post(`/api/products/${route.params.id}`, formData, { headers, params })
  .then((response) => {
    router.push("/admin/products");

    toastrAlert.default(response.data.message);
  })
  .catch((error) => {
    toastrAlert.error(error);
  });
}

onMounted(() => {
  getProduct();
  getCategories();
});
</script>

<template>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <RouterLink to="/admin/products">Home</RouterLink>
            </li>
            <li class="breadcrumb-item active">Edit Product</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Details</h3>
            </div>
            <FormWizard
              :validation-schema="validationSchema"
              @submit="onSubmit"
            >
              <FormStep>
                <div class="form-group">
                  <label for="product-name">Product Name</label>
                  <Field
                    v-model="product.name"
                    name="name"
                    type="text"
                    placeholder="Type the product name"
                    class="form-control"
                    id="product-name"
                  />
                  <ErrorMessage name="name" class="text-red" />
                </div>

                <div class="form-group">
                  <label for="product-name">Product Category</label>
                  <Field
                    v-model="product.category_id"
                    name="category_id"
                    as="select"
                    class="form-control"
                    id="product-category"
                  >
                    <option value="">Select a Category</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </Field>
                  <ErrorMessage name="category_id" class="text-red" />
                </div>

                <div class="form-group">
                  <label for="product-description">Product Description</label>
                  <Field
                    v-model="product.description"
                    name="description"
                    as="textarea"
                    placeholder="Type the product description"
                    class="form-control"
                    id="product-description"
                  />
                  <ErrorMessage name="description" class="text-red" />
                </div>
              </FormStep>

              <FormStep>
                <div class="form-group">
                  <label for="product-description">Product Images</label>
                  <div class="mt-2 mb-2">
                    <img style="max-width: 400px;" v-for="(url, index) in product.images" :key="index" :src="url">
                  </div>
                  <Field
                    type="file"
                    multiple
                    name="images"
                    accept="image/png, image/jpeg"
                    class="form-control"
                  />
                  <ErrorMessage name="images" class="text-red" />
                </div>
              </FormStep>

              <FormStep>
                <div class="form-group">
                  <label for="product-date-and-time">Date and Time</label>
                  <Field
                    v-model="product.date_and_time"
                    name="date_and_time"
                    type="datetime-local"
                    class="form-control"
                    id="product-date-and-time"
                  />
                  <ErrorMessage name="date_and_time" class="text-red" />
                </div>
              </FormStep>
            </FormWizard>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
