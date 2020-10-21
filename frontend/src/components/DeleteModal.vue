<template>
  <v-dialog v-model="show" max-width="500px" height="1000px" persistent>
    <v-card class="pa-9">
      <h1 class="text-center">Confirm delete</h1>
      <v-card-actions />
      <v-btn color="primary" @click="onSubmit">Confirm</v-btn>
      <v-btn color="secundary" @click="onClose">Close</v-btn>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    visible: { type: Boolean, default: false },
    product: { type: Number, default: -1 },
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
          this.$emit('closeDelete')
        }
      },
    },
  },
  methods: {
    onSubmit() {
      this.show = false
      this.$emit('submitDelete', this.product)
    },
    onClose() {
      this.show = false
    },
  },
}
</script>
