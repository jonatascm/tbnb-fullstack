<template>
  <div>
    <h1 class="text-center">Product List</h1>
    <div class="mx-auto">
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            @click="selectProduct(-1, {}, 'form')"
          >
            <v-icon color="green lighten-1">fas fa-plus</v-icon>
          </v-btn>
        </template>
        <span>Add</span>
      </v-tooltip>
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            @click="showBatchMovementModal = true"
          >
            <v-icon color="brown lighten-1">fas fa-clipboard-list</v-icon>
          </v-btn>
        </template>
        <span>Batch Movement</span>
      </v-tooltip>
    </div>
    <v-container class="mx-auto" fluid style="margin-top: 60px; width: 30%">
      <v-list>
        <v-list-item v-for="(product, index) in products" :key="product.id">
          <v-list-item-content>
            <v-list-item-title v-text="product.name" />
            <v-list-item-subtitle v-text="product.description" />
            <v-list-item-subtitle v-text="`Quantity: ${product.quantity}`" />
          </v-list-item-content>
          <v-list-item-action class="d-flex flex-row mb-6">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="selectProduct(index, product, 'movement')"
                >
                  <v-icon color="brown lighten-1">fas fa-exchange-alt</v-icon>
                </v-btn>
              </template>
              <span>Movements</span>
            </v-tooltip>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="selectProduct(index, product, 'form')"
                >
                  <v-icon color="blue lighten-1">fas fa-edit</v-icon>
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
                  @click="selectProduct(index, product, 'delete')"
                >
                  <v-icon color="red lighten-1">fas fa-trash </v-icon>
                </v-btn>
              </template>
              <span>Delete</span>
            </v-tooltip>
          </v-list-item-action>
        </v-list-item>
      </v-list>
    </v-container>
    <ProductForm
      :visible="showProductForm"
      :product="selectedProduct"
      @close="showProductForm = false"
      @submit="submitEditAction"
      @submitAdd="submitAddAction"
    />
    <DeleteModal
      :visible="showDeleteModal"
      :product="indexProduct"
      @closeDelete="showDeleteModal = false"
      @submitDelete="submitDeleteAction"
    />
    <ProductMovement
      :visible="showMovementModal"
      :product="selectedProduct"
      @closeMovement="showMovementModal = false"
    />
    <BatchMovement
      :visible="showBatchMovementModal"
      :products="products"
      @sendBatchMovement="sendBatchMovement"
      @closeMovement="showBatchMovementModal = false"
    />
  </div>
</template>

<script>
import ProductForm from './ProductForm'
import DeleteModal from './DeleteModal'
import ProductMovement from './ProductMovement'
import BatchMovement from './BatchMovement'

export default {
  name: 'ProductList',
  components: {
    ProductForm,
    DeleteModal,
    ProductMovement,
    BatchMovement,
  },
  data: () => ({
    selectedProduct: {},
    indexProduct: 0,
    products: [
      {
        name: 'Product1',
        description: 'Product One Description',
        id: 'uuid-id1',
        quantity: 20,
        movements: [],
      },
      {
        name: 'Product2',
        description: 'Product Two Description',
        id: 'uuid-id2',
        quantity: 56,
        movements: [],
      },
      {
        name: 'Product3',
        description: 'Product Three Description',
        id: 'uuid-id3',
        quantity: 179,
        movements: [],
      },
    ],
    showProductForm: false,
    showDeleteModal: false,
    showMovementModal: false,
    showBatchMovementModal: false,
  }),
  methods: {
    selectProduct(index, product, type) {
      this.indexProduct = index
      switch (type) {
        case 'form':
          this.selectedProduct = { ...product }
          this.showProductForm = true
          break
        case 'delete':
          this.showDeleteModal = true
          break
        case 'movement':
          this.selectedProduct = product
          this.showMovementModal = true
          break
        default:
          break
      }
    },
    deleteProduct(index, product) {
      this.selectedProduct = { ...product }
      this.showDeleteModal = true
    },
    submitAddAction(product) {
      product.id = `uuid-${Math.random()}`
      product.quantity = 0
      product.movements = []
      this.products.push(product)
    },
    submitEditAction(product) {
      const newProducts = this.products.map((thisProduct) => {
        if (thisProduct.id === product.id) {
          return product
        }

        return thisProduct
      })

      this.products = newProducts
    },
    submitDeleteAction(index) {
      this.products.splice(index, 1)
    },
    sendBatchMovement(movements) {
      movements.map((movement) => {
        const product = this.products.find(
          (product) => product.id === movement.product.id
        )
        if (product) {
          movement.productId = movement.product.id
          product.movements.push(movement)
          console.log(movement.type)
          if (movement.type === 'buy') {
            product.quantity += movement.quantity
          } else if (movement.type === 'sell') {
            product.quantity -= movement.quantity
          }
        }
      })
    },
  },
}
</script>
