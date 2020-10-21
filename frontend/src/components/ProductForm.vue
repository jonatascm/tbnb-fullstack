<template>
  <v-dialog v-model="show" max-width="500px" height="1000px" persistent>
    <v-card class="pa-9">
      <h1 class="text-center">Product Form</h1>
      <v-form ref="form" lazy-validation>
        <v-text-field v-model="product.name" label="Product" />
        <v-text-field v-model="product.description" label="Description" />
      </v-form>
      <v-card-actions />
      <v-btn color="primary" @click="onSubmit">Save</v-btn>
      <v-btn color="secundary" @click="onClose">Close</v-btn>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    visible: { type: Boolean, default: false },
    product: {
      type: Object,
      default: () => {
        return {}
      },
    },
    submitAction: {
      type: Function,
      default: () => {},
    },
  },
  data() {
    return {
      oldProduct: this.product,
    }
  },
  computed: {
    show: {
      get() {
        return this.visible
      },
      set(value) {
        if (!value) {
          this.$emit('close')
        }
      },
    },
  },
  methods: {
    onSubmit() {
      this.show = false
      if (this.product.id) {
        this.$emit('submit', this.product)
      } else {
        this.$emit('submitAdd', this.product)
      }
    },
    onClose() {
      this.show = false
    },
  },
}
</script>
