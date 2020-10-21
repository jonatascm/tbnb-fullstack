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
        <transition-group name="list-animation">
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
                    @click="deleteMovement(index, movement)"
                  >
                    <v-icon medium color="red lighten-1">fas fa-trash </v-icon>
                  </v-btn>
                </template>
                <span>Delete</span>
              </v-tooltip>
            </v-list-item-action>
          </v-list-item>
        </transition-group>
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
    async onAdd() {
      this.$emit('addMovement', {
        type: this.type,
        id: this.movementId,
        quantity: parseInt(this.quantity),
        productId: this.product.id,
      })
      this.type = 'buy'
      this.quantity = 0
      this.movementId = null
    },
    onClose() {
      this.show = false
    },
    async deleteMovement(index, movement) {
      this.$emit('deleteMovement', { ...movement, product: this.product })
    },
    editMovement(movement) {
      this.type = movement.type
      this.quantity = parseInt(movement.quantity)
      this.movementId = movement.id
      console.log('Aqui!')
    },
  },
}
</script>

<style>
.list-animation-enter-active {
  animation: fade-in 0.5s;
}

.list-animation-leave-active {
  animation: fade-out 0.5s;
}

@keyframes fade-in {
  0% {
    transform: translateX(-30px);
    opacity: 0;
  }
  50% {
    transform: translateX(30px);
    opacity: 0.5;
  }

  100% {
    transform: translateX(0px);
    opacity: 1;
  }
}

@keyframes fade-out {
  0% {
    transform: translateX(0px);
    opacity: 1;
  }
  50% {
    transform: translateX(-20px);
    opacity: 0.5;
  }

  100% {
    transform: translateX(30px);
    opacity: 0;
  }
}
</style>
