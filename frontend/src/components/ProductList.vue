<template>
  <div>
    <h1 class="text-center">TBNB - Product List</h1>
    <div class="d-flex justify-center pa-9">
      <img width="100" height="100" src="../assets/logo.svg" />
    </div>
    <div class="d-flex justify-center pt-9">
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
        <template v-for="(product, index) in products">
          <v-list-item :key="product.id">
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
          <v-divider :key="index" />
        </template>
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
      @addMovement="addMovement"
      @deleteMovement="deleteMovement"
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
import dataService from '../services/data-service'

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
    products: [],
    showProductForm: false,
    showDeleteModal: false,
    showMovementModal: false,
    showBatchMovementModal: false,
  }),
  created() {
    this.fetchProducts()
  },
  methods: {
    async fetchProducts() {
      try {
        const products = await dataService.fetchProducts()
        this.products = products
      } catch (err) {
        console.log(err)
      }
    },
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
    async submitAddAction(product) {
      try {
        product.quantity = 0
        product.movements = []
        const fetchProduct = await dataService.createProduct(product)
        this.products.push(fetchProduct)
      } catch (err) {
        console.log(err)
      }
    },
    async submitEditAction(product) {
      try {
        await dataService.updateProduct(product)
        const newProducts = this.products.map((thisProduct) => {
          if (thisProduct.id === product.id) {
            return product
          }

          return thisProduct
        })

        this.products = newProducts
      } catch (err) {
        console.log(err)
      }
    },
    async submitDeleteAction(index) {
      try {
        await dataService.deleteProduct(this.products[index].id)
        this.products.splice(index, 1)
      } catch (err) {
        console.log(err)
      }
    },
    async sendBatchMovement(movements) {
      const fetchMovements = await dataService.createBatchMovement(movements)
      fetchMovements.map((movement) => {
        const product = this.products.find(
          (product) => product.id === movement.product.id
        )
        if (product) {
          movement.productId = movement.product.id
          product.quantity = movement.product.quantity
          product.movements.push(movement)
        }
      })
    },
    async addMovement(movement) {
      try {
        const productIndex = this.products.findIndex(
          (prod) => prod.id === movement.productId
        )

        if (movement.id) {
          const fetchMovement = await dataService.updateMovement(movement)

          this.products[productIndex].movements.map((move) => {
            if (move.id === movement.id) {
              move.type = movement.type
              move.quantity = parseInt(movement.quantity)
            }
          })

          this.products[productIndex].quantity = fetchMovement.product.quantity
        } else {
          const fetchMovement = await dataService.createMovement(movement)
          this.products[productIndex].movements.push(fetchMovement)
          this.products[productIndex].quantity = fetchMovement.product.quantity
        }
      } catch (err) {
        console.log(err)
      }
    },
    async deleteMovement(movement) {
      try {
        const productIndex = this.products.findIndex(
          (prod) => prod.id === movement.product.id
        )

        await dataService.deleteMovement(movement.id)

        if (movement.type === 'sell') {
          this.products[productIndex].quantity += parseInt(movement.quantity)
        } else if (movement.type === 'buy') {
          this.products[productIndex].quantity -= parseInt(movement.quantity)
        }

        this.products[productIndex].movements = this.products[
          productIndex
        ].movements.filter((move) => move.id !== movement.id)
      } catch (err) {
        console.log(err)
      }
    },
  },
}
</script>
