class DataService {
  constructor() {
    if (DataService.instance) {
      return DataService.instance
    }
    DataService.instance = this
  }

  loadDataProviderConfig = async () => {
    this._dataProvider = (await import('./remote-data-provider')).default
  }

  getDataProvider = async () => {
    if (!this._dataProvider) {
      await this.loadDataProviderConfig()
    }
    return this._dataProvider
  }

  create = async (resource, data) => {
    const dataProvider = await this.getDataProvider()
    const result = await dataProvider('CREATE', resource, { data })
    return result
  }

  deleteOne = async (resource, id) => {
    const dataProvider = await this.getDataProvider()
    return await dataProvider('DELETE', resource, { id })
  }

  fetchOne = async (resource, id) => {
    const dataProvider = await this.getDataProvider()
    const result = await dataProvider('GET_ONE', resource, { id })

    return result ? result : null
  }

  fetchList = async (resource, filter = {}) => {
    const dataProvider = await this.getDataProvider()
    const result = await dataProvider('GET_LIST', resource, {
      filter,
    })
    return result ? result : null
  }

  update = async (resource, data) => {
    const dataProvider = await this.getDataProvider()
    const result = await dataProvider('UPDATE', resource, {
      id: data.id,
      data,
    })
    return result
  }

  batchUpdate = async (resource, data) => {
    const dataProvider = await this.getDataProvider()
    const result = await dataProvider('BATCH_UPDATE', resource, {
      data,
    })
    return result
  }

  async fetchProducts() {
    return await this.fetchList('products')
  }

  async fetchProduct(productId) {
    return await this.fetchOne('products', productId)
  }

  async createProduct(product) {
    return await this.create('products', product)
  }

  async deleteProduct(productId) {
    return await this.deleteOne('products', productId)
  }

  async updateProduct(product) {
    return await this.update('products', product)
  }

  async createMovement(movement) {
    return await this.create('product_movements', movement)
  }

  async updateMovement(movement) {
    return await this.update('product_movements', movement)
  }

  async deleteMovement(movementId) {
    return await this.deleteOne('product_movements', movementId)
  }

  async createBatchMovement(movements) {
    return await this.batchUpdate('product_movements', movements)
  }
}

export default new DataService()
