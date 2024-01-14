
<script setup>
import { useForm } from "vee-validate";
import { ref, computed, provide } from "vue";

const props = defineProps({
  validationSchema: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(["submit"]);
const currentStepIdx = ref(0);

const stepCounter = ref(0);
provide("STEP_COUNTER", stepCounter);

provide("CURRENT_STEP_INDEX", currentStepIdx);

const isLastStep = computed(() => {
  return currentStepIdx.value === stepCounter.value - 1;
});

const hasPrevious = computed(() => {
  return currentStepIdx.value > 0;
});

const currentSchema = computed(() => {
  return props.validationSchema[currentStepIdx.value];
});

const { values, handleSubmit } = useForm({
  validationSchema: currentSchema,
  keepValuesOnUnmount: true,
});

const onSubmit = handleSubmit((values) => {
  if (!isLastStep.value) {
    currentStepIdx.value++;

    return;
  }

  emit("submit", values);
});

function goToPrev() {
  if (currentStepIdx.value === 0) {
    return;
  }

  currentStepIdx.value--;
}
</script>
<template>
  <form @submit="onSubmit">
    <div class="card-body">
      <slot />

      <div class="form-group ml-1">
        <!-- <button
          v-if="hasPrevious"
          type="button"
          @click="goToPrev"
          class="btn btn-info mr-2"
        >
          Previous
        </button> -->
        <button type="submit" class="btn btn-success">
          {{ isLastStep ? "Submit" : "Next" }}
        </button>
      </div>

      <pre>{{ values }}</pre>
    </div>
  </form>
</template>
