<template>
  <v-dialog v-model="show" max-width="500px" height="1000px">
    <v-card class="pa-9">
      <h1 class="text-center">Batch Movement</h1>
      <v-form ref="form" lazy-validation>
        <v-select
          v-model="selectProduct"
          item-text="name"
          :items="products"
          return-object
          label="Select a product"
        />
        <v-text-field v-model="quantity" label="Quantity" />
        <v-radio-group v-model="type">
          <v-radio label="Buy" value="buy" />
          <v-radio label="Sell" value="sell" />
        </v-radio-group>
        <v-btn color="primary" @click="onAdd">Add</v-btn>
      </v-form>
      <div v-if="!movements.length">
        <h2 class="text-center">No batch movement</h2>
      </div>
      <v-list>
        <v-list-item v-for="(movement, index) in movements" :key="movement.id">
          <v-list-item-content>
            <v-list-item-title v-text="movement.product.name" />
            <v-list-item-subtitle v-text="movement.quantity" />
            <v-list-item-subtitle v-text="movement.type" />
          </v-list-item-content>
          <v-list-item-action class="d-flex flex-row mb-6">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="editMovement(movement, index)"
                >
                  <v-icon medium color="blue lighten-1">fas fa-edit</v-icon>
                </v-btn>
              </template>
              <span>Edit</span>
            </v-tooltip>

            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="deleteMovement(index)"
                >
                  <v-icon medium color="red lighten-1">fas fa-trash </v-icon>
                </v-btn>
              </template>
              <span>Delete</span>
            </v-tooltip>
          </v-list-item-action>
        </v-list-item>
      </v-list>
      <v-btn color="primary" @click="onSendBatch">Send batch</v-btn>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    products: {
      type: Array,
      default: () => [],
    },
    visible: { type: Boolean, default: false },
  },
  data() {
    return {
      type: 'buy',
      quantity: 0,
      movementId: null,
      selectProduct: null,
      movements: [],
    }
  },
  computed: {
    show: {
      get() {
        return this.visible
      },
      set(value) {
        if (!value) {
          this.$emit('closeMovement')
        }
      },
    },
  },
  methods: {
    onAdd() {
      if (this.movementId !== null) {
        const movement = this.movements[this.movementId]

        movement.type = this.type
        movement.quantity = parseInt(this.quantity)
        movement.product = this.selectProduct
      } else {
        this.movements.push({
          type: this.type,
          quantity: parseInt(this.quantity),
          product: this.selectProduct,
        })
      }
      this.type = 'buy'
      this.quantity = 0
      this.movementId = null
      this.selectProduct = null
    },
    onClose() {
      this.show = false
    },
    deleteMovement(index) {
      this.movements.splice(index, 1)
    },
    editMovement(movement, index) {
      this.type = movement.type
      this.quantity = movement.quantity
      this.movementId = index
      this.selectProduct = movement.product
    },
    onSendBatch() {
      this.$emit('sendBatchMovement', this.movements)
      this.movements = []
      this.show = false
    },
  },
}
</script>
