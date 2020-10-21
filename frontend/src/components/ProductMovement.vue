<template>
  <v-dialog v-model="show" max-width="500px" height="1000px">
    <v-card class="pa-9">
      <h1 class="text-center">Product Movement</h1>
      <v-form ref="form" lazy-validation>
        <v-text-field v-model="quantity" label="Quantity" />
        <v-radio-group v-model="type">
          <v-radio label="Buy" value="buy" />
          <v-radio label="Sell" value="sell" />
        </v-radio-group>
        <v-btn color="primary" @click="onAdd">Add</v-btn>
      </v-form>
      <div v-if="!product.movements">
        <h2 class="text-center">No movement</h2>
      </div>
      <v-list>
        <v-list-item
          v-for="(movement, index) in product.movements"
          :key="movement.id"
        >
          <v-list-item-content>
            <v-list-item-title v-text="movement.quantity" />
            <v-list-item-subtitle v-text="movement.type" />
          </v-list-item-content>
          <v-list-item-action class="d-flex flex-row mb-6">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="editMovement(movement)"
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
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      default: () => {
        return {}
      },
    },
    visible: { type: Boolean, default: false },
  },
  data() {
    return {
      type: 'buy',
      quantity: 0,
      movementId: null,
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
      if (this.movementId) {
        const movement = this.product.movements.find(
          (mov) => mov.id === this.movementId
        )
        if (movement.type === 'sell') {
          this.product.quantity += parseInt(movement.quantity)
        } else if (movement.type === 'buy') {
          this.product.quantity -= parseInt(movement.quantity)
        }

        movement.type = this.type
        movement.quantity = parseInt(this.quantity)
      } else {
        this.product.movements.push({
          id: `uuid-${Math.random()}`,
          type: this.type,
          quantity: parseInt(this.quantity),
        })
      }

      if (this.type === 'sell') {
        this.product.quantity -= parseInt(this.quantity)
      } else if (this.type === 'buy') {
        this.product.quantity += parseInt(this.quantity)
      }
      this.type = 'buy'
      this.quantity = 0
      this.movementId = null
    },
    onClose() {
      this.show = false
    },
    deleteMovement(index) {
      const movement = this.product.movements[index]

      if (movement.type === 'sell') {
        this.product.quantity += parseInt(movement.quantity)
      } else if (movement.type === 'buy') {
        this.product.quantity -= parseInt(movement.quantity)
      }

      this.product.movements.splice(index, 1)
    },
    editMovement(movement) {
      this.type = movement.type
      this.quantity = movement.quantity
      this.movementId = movement.id
    },
  },
}
</script>
