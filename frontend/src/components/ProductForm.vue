<template>
  <v-dialog v-model="show" max-width="500px" height="1000px" persistent>
    <v-card class="pa-9">
      <h1 class="text-center">Product Form</h1>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
          v-model="product.name"
          :rules="required"
          label="Product"
        />
        <v-text-field
          v-model="product.description"
          :rules="required"
          label="Description"
        />
      </v-form>
      <v-card-actions class="d-flex justify-space-around pt-9">
        <v-btn :disabled="!valid" color="primary" @click="onSubmit">Save</v-btn>
        <v-btn color="secundary" @click="onClose">Close</v-btn>
      </v-card-actions>
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
      valid: true,
      name: this.product.name,
      description: this.product.description,
      id: this.product.id,
      required: [(v) => !!v || 'Is required'],
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
      this.$refs.form.validate()
      this.show = false
      if (this.product.id) {
        this.$emit('submit', {
          id: this.product.id,
          name: this.product.name,
          description: this.product.description,
        })
      } else {
        this.$emit('submitAdd', {
          name: this.product.name,
          description: this.product.description,
        })
      }
      this.name = ''
      this.description = ''
      this.id = ''
    },
    onClose() {
      this.show = false
    },
  },
}
</script>
