import axios from 'axios'

const fetchRest = async (restMethod, resource, params) => {
  const backendUrl = process.env.VUE_APP_API_URL
  switch (restMethod) {
    case 'GET_LIST': {
      const url = `${backendUrl}/${resource}`
      const result = await axios.get(url, {
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*',
        },
      })
      if (result?.status !== 200) {
        throw new Error(`GET_LIST ${resource}: ${result?.statusText}`)
      }
      return await result.data
    }

    case 'GET_ONE': {
      const { id } = params
      const url = `${backendUrl}/${resource}/${id}`
      const result = await fetch(url, {
        headers: {
          'Content-Type': 'application/json',
        },
      })
      if (!result.ok) {
        throw new Error(`GET_ONE ${resource}: ${result.statusText}`)
      }

      return await result.json()
    }

    case 'CREATE': {
      const { data } = params
      const url = `${backendUrl}/${resource}`
      const result = await axios.post(url, data)
      if (result?.status !== 200) {
        throw new Error(`CREATE ${resource}: ${result.statusText}`)
      }
      return result.data
    }

    case 'DELETE': {
      const { id } = params
      const url = `${backendUrl}/${resource}/${id}`
      const result = await axios.delete(url)
      if (result?.status !== 200) {
        throw new Error(`DELETE ${resource}[${id}]: ${result.statusText}`)
      }
      return result.data
    }

    case 'UPDATE': {
      const { id, data } = params
      const url = `${backendUrl}/${resource}/${id}`
      const result = await axios.put(url, data)
      if (result?.status !== 200) {
        throw new Error(`UPDATE ${resource}[${id}]: ${result.statusText}`)
      }

      return result.data
    }

    case 'BATCH_UPDATE': {
      const { data } = params
      const url = `${backendUrl}/${resource}/batch-create/`
      const result = await axios.post(url, data)
      if (result?.status !== 200) {
        throw new Error(
          `UPDATE ${resource}[batch-update]: ${result.statusText}`
        )
      }

      return result.data
    }

    default:
      return null
  }
}

export const remoteDataProvider = {
  fetchRest,
}

export default fetchRest
